<?php

namespace Nihardas\TestShortcode;

use FluentCrm\App\Models\SubscriberNote;
use FluentCrm\App\Services\Funnel\FunnelHelper;
use FluentCrm\App\Services\Helper;
use FluentCrm\App\Services\Libs\Mailer\Mailer;

class ExternalActivity
{
    public function __construct()
    {
        $this->actionName = 'add_external_activity';
        $this->priority = 99;

        add_filter('fluentcrm_funnel_blocks', array($this, 'pushBlock'), $this->priority, 2);
        add_filter('fluentcrm_funnel_block_fields', array($this, 'pushBlockFields'), $this->priority, 2);
        add_action('fluentcrm_funnel_sequence_handle_' . $this->actionName, array($this, 'handle'), 10, 4);
    }

    public function pushBlock($blocks, $funnel)
    {
        $this->funnel = $funnel;

        $block = [
            'category' => __('Nihar'),
            'title'       => __('External Activity'),
            'description' => __('Add External Notes or Activity to the Contact Profile and send note mail to administrator'),
            'icon'        => 'fc-icon-writing',
            'settings'    => [
                'type'        => 'note',
                'title'       => '',
                'description' => ''
            ]
        ];
        if($block) {
            $block['type'] = 'action';
            $blocks[$this->actionName] = $block;
        }

        return $blocks;
    }

    public function pushBlockFields($fields, $funnel)
    {
        $this->funnel = $funnel;


        $noteTypes = fluentcrm_activity_types();
        $typesOptions = [];
        foreach ($noteTypes as $type => $label) {
            $typesOptions[] = [
                'id'    => $type,
                'title' => $label
            ];
        }

        $fields[$this->actionName] = [
            'title'     => __('External Activity'),
            'sub_title' => __('Add External Notes or Activity to the Contact Profile and send note mail to administrator'),
            'fields'    => [
                'type' => [
                    'type'    => 'select',
                    'label'   => __('Select Activity Type'),
                    'options' => $typesOptions
                ],
                'title' => [
                    'type' => 'input-text',
                    'label' => __('Activity Title')
                ],
                'description' => [
                    'type' => 'html_editor',
                    'label' => __('Description')
                ],
                'email_notification' => [
                    'type' => 'yes_no_check',
                    'label'       => '',
                    'check_label' => __('Do you want to sent e-mail notification?'),
                    'inline_help'        => __('If you enable, then it will sent e-mail notification to your client every time this funnel triggers')
                ]
            ]
        ];
        return $fields;
    }

    public function handle($subscriber, $sequence, $funnelSubscriberId, $funnelMetric)
    {
        $description = wp_unslash($sequence->settings['description']);
        $title = sanitize_text_field($sequence->settings['title']);
        $type = sanitize_text_field($sequence->settings['type']);
        $email_notification = rest_sanitize_boolean($sequence->settings['email_notification']);

        if(!$description || !$title || !$type) {
            FunnelHelper::changeFunnelSubSequenceStatus($funnelSubscriberId, $sequence->id, 'skipped');
            return false;
        }

        SubscriberNote::create([
            'description' => $description,
            'title' => $title,
            'type' => $type,
            'created_by' => $sequence->created_by,
            'subscriber_id' => $subscriber->id
        ]);

        $data = [
            'to'      => [
                'email' => ''
            ],
            'subject' => $title,
            'body'    => $description,
            'headers' => Helper::getMailHeader()
        ];


        if ($email_notification) {
            Helper::maybeDisableEmojiOnEmail();
            Mailer::send($data);
        }
    }

}
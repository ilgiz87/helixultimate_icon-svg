<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

use Joomla\CMS\Factory;

/**
 * Helix Ultimate contact information.
 *
 * @since	1.0.0
 */
class HelixUltimateFeatureContact
{
    /**
     * Template parameters
     *
     * @var	object	$params	The parameters object
     * @since	1.0.0
     */
    private $params;
    public $position;
    public $load_pos;

    /**
     * Constructor function
     *
     * @param	object	$params	The template parameters
     *
     * @since	1.0.0
     */
    public function __construct($params)
    {
        $this->params = $params;
        $this->position = $this->params->get('contact_position', 'top1');
        $this->load_pos = $this->params->get('social_load_pos', 'default');
    }

    /**
     * Render the contact features
     *
     * @return	string
     * @since	1.0.0
     */
    public function renderFeature()
    {
        $conditions = $this->params->get('contactinfo') && ($this->params->get('contact_phone') || $this->params->get('contact_mobile') || $this->params->get('contact_email') || $this->params->get('contact_time'));

        if ($conditions)
        {
            $output = '<ul class="sp-contact-info">';

            if ($this->params->get('contact_phone'))
            {
                $output .= '<li class="sp-contact-phone"> <a href="tel:' . $this->cleanPhoneNumber($this->params->get('contact_phone')) . '">' . $this->getSvgIcon('phone') . ' ' . htmlspecialchars($this->params->get('contact_phone')) . '</a></li>';
            }

            if ($this->params->get('contact_mobile'))
            {
                $output .= '<li class="sp-contact-mobile"> <a href="tel:' . $this->cleanPhoneNumber($this->params->get('contact_mobile')) . '">' . $this->getSvgIcon('mobile') . ' ' . htmlspecialchars($this->params->get('contact_mobile')) . '</a></li>';
            }

            if ($this->params->get('contact_email'))
            {
                $output .= '<li class="sp-contact-email"> <a href="mailto:' . htmlspecialchars($this->params->get('contact_email')) . '">' . $this->getSvgIcon('email') . ' ' . htmlspecialchars($this->params->get('contact_email')) . '</a></li>';
            }

            if ($this->params->get('contact_time'))
            {
                $output .= '<li class="sp-contact-time">' . $this->getSvgIcon('clock') . ' ' . htmlspecialchars($this->params->get('contact_time')) . '</li>';
            }

            $output .= '</ul>';

            return $output;
        }
    }

    /**
     * Get SVG icon markup
     *
     * @param string $iconName
     * @return string
     */
    private function getSvgIcon($iconName)
    {
        $template = Factory::getApplication()->getTemplate();
        $iconPath = JPATH_THEMES . '/' . $template . '/svg-icons/' . $iconName . '.svg';
        if (file_exists($iconPath)) {
            $svg = file_get_contents($iconPath);
            $svg = preg_replace('/<svg(.*?)>/i', '<svg$1 fill="currentColor" height="1em">', $svg);
            return $svg;
        }
        return '';
    }

    /**
     * Clean phone number format
     *
     * @param string $phoneNumber
     * @return string
     */
    private function cleanPhoneNumber($phoneNumber)
    {
        return preg_replace('/[^0-9+]/', '', $phoneNumber);
    }
}
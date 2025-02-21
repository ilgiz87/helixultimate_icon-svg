<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

/**
 * Helix Ultimate social media information.
 *
 * @since	1.0.0
 */
class HelixUltimateFeatureSocial
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
		$this->position = $this->params->get('social_position');
		$this->load_pos = $this->params->get('social_load_pos', 'default');
	}

	/**
	 * Render the social media features
	 *
	 * @return	string
	 * @since	1.0.0
	 */
	public function renderFeature()
	{
		$socials = array(
			'facebook' => $this->params->get('facebook'),
			'twitter' => $this->params->get('twitter'),
			'pinterest' => $this->params->get('pinterest'),
			'youtube' => $this->params->get('youtube'),
			'linkedin' => $this->params->get('linkedin'),
			'dribbble' => $this->params->get('dribbble'),
			'instagram' => $this->params->get('instagram'),
			'behance' => $this->params->get('behance'),
			'skype' => $this->params->get('skype'),
			'whatsapp' => $this->params->get('whatsapp'),
			'flickr' => $this->params->get('flickr'),
			'vk' => $this->params->get('vk'),
			'custom' => $this->params->get('custom'),
		);

		$hasAnySocialLink = array_reduce(
			$socials,
			function ($acc, $curr) {
				return $acc || !empty($curr);
			},
			false
		);

		if ($this->params->get('show_social_icons') && $hasAnySocialLink) {
			$html = '<ul class="social-icons">';

			foreach ($socials as $name => $link) {
				if (!empty($link)) {
					$iconName = $name;

					if ($name === 'skype') {
						$link = 'skype:' . $link . '?chat';
					} elseif ($name === 'whatsapp') {
						$link = 'https://wa.me/' . $link . '?text=Hi';
					} elseif ($name === 'custom') {
						$array = explode(' ', trim($link), 2);
						if (count($array) === 2) {
							$iconName = $array[0];
							$link = $array[1];
						}
					}

					$html .= '<li class="social-icon-' . $name . '"><a target="_blank" rel="noopener noreferrer" href="' . htmlspecialchars($link) . '" aria-label="' . ucfirst($name) . '">' . $this->getSvgIcon($iconName) . '</a></li>';
				}
			}

			$html .= '</ul>';
			return $html;
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
		$iconPath = JPATH_ROOT . '/templates/shaper_helixultimate/svg-icons/' . $iconName . '.svg';
		if (file_exists($iconPath)) {
			$svg = file_get_contents($iconPath);
			$svg = preg_replace('/<svg /', '<svg fill="currentColor" height="1em" ', $svg, 1);
			return $svg;
		}
		return '';
	}
}

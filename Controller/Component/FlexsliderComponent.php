<?php

App::uses('Component', 'Controller');
App::uses('StringConverter', 'Croogo.Lib/Utility');

class FlexsliderComponent extends Component {
/**
 * Sliders for layout
 *
 * @var string
 * @access public
 */
	public $slidersForLayout = array();

/**
 * initialize
 *
 * @param Controller $controller instance of controller
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
		$this->_stringConverter = new StringConverter();
		if (isset($controller->Slider)) {
			$this->Slider = $controller->Slider;
		} else {
			$this->Slider = ClassRegistry::init('Flexslider.Slider');
		}
	}

/**
 * Startup
 *
 * @param Controller $controller instance of controller
 * @return void
 */
	public function startup(Controller $controller) {
		if (!isset($controller->request->params['admin']) && !isset($controller->request->params['requested'])) {
			$this->sliders();
		}
	}

/**
 * beforeRender
 *
 * @param Controller $controller instance of controller
 * @return void
 */
	public function beforeRender(Controller $controller) {
		$controller->set('sliders_for_layout', $this->slidersForLayout);
	}

	/**
	 * Blocks
	 *
	 * Blocks will be available in this variable in views: $blocks_for_layout
	 *
	 * @return void
	 */
	public function sliders() {
		$request = $this->controller->request;
		$slug = Inflector::slug(strtolower($request->url));
		$sliders = $this->Slider->find('active');
		foreach ($sliders as $slider) {
			$sliderId = $slider['Slider']['id'];
			$sliderAlias = $slider['Slider']['alias'];
			$cacheKey = $sliderAlias;
			$this->slidersForLayout[$sliderAlias] = array();

			$visibilityCachePrefix = 'visibility_' .  $slug . '_' . $cacheKey;
			$sliders = Cache::read($visibilityCachePrefix, 'flexslider_sliders');
			if ($sliders === false) {

				$sliders = $this->Slider->Item->find('published', array(
						'sliderId' => $sliderId,
						'cacheKey' => $cacheKey,
					));

				Cache::write($visibilityCachePrefix, $sliders, 'croogo_sliders');
			}
			$this->slidersForLayout[$sliderAlias] = $sliders;
			$this->slidersForLayout[$sliderAlias]['Slider'] = $slider['Slider'];
		}
	}

} 
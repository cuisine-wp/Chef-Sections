<?php

	namespace ChefSections\Admin\Ui\Containers;

	use ChefSections\Helpers\SectionUi as SectionUiHelper;

	class TabbedUi{

		/**
		 * Container class
		 * 
		 * @var ChefSections\SectionTypes\
		 */
		protected $container;


		/**
		 * Constructor
		 * 
		 * @param ChefSections\SectionTypes\Container
		 *
		 * @return void
		 */
		public function __construct( $container)
		{
			$this->container = $container;
		}


		/**
		 * Builds the UI for a tabbed container
		 * 
		 * @return string (html, echoed)
		 */
		public function build()
		{

			$this->buildNav();

			echo '<div class="tabbed-content section-data" id="tabsFor'.$this->container->id.'">';

				if( !$this->container->sections->empty() ){

					foreach( $this->container->sections->all() as $section ){

						SectionUiHelper::getClass( $section )->build();

					}
				}

			echo '</div>';	
		}

		/**
		 * Build the navigation
		 * 
		 * @return string (html,echoed )
		 */
		public function buildNav()
		{
			echo '<div class="section-sortables tab-nav" data-container_id="'.$this->container->id.'">';

				if( !$this->container->sections->empty() ){

					$i = 0;
					foreach( $this->container->sections->all() as $section ){

						echo static::getTab( $section, ( $i == 0 ) );
						$i++;
					}

				}

			echo '</div>';
		}


		public static function getTab( $section, $active = false )
		{
			$title = $section->getProperty( 'tab_title', $section->title );
			$position = $section->getProperty( 'position' );
			$class = 'tab';

			if( $active )
				$class .= ' active';

			$html = '<div class="'.$class.'" data-id="'.$section->id.'">';
				$html .= '<span class="title">'.$title.'</span>';
				$html .= '<span class="dashicons dashicons-leftright"></span>';
			$html .= '</div>';

			return $html;
		}


	}
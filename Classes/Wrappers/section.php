<?php

namespace ChefSections\Wrappers;

class Section extends Wrapper {

    /**
     * Return the igniter service key responsible for the Column class.
     * The key must be the same as the one used in the assigned
     * igniter service.
     *
     * @return string
     */
    protected static function getFacadeAccessor(){
        return 'section';
    }

}

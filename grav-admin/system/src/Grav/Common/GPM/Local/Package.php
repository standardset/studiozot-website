<?php

/**
 * @package    Grav\Common\GPM
 *
 * @copyright  Copyright (C) 2015 - 2019 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Common\GPM\Local;

use Grav\Common\Data\Data;
use Grav\Common\GPM\Common\Package as BasePackage;
use Grav\Framework\Parsedown\Parsedown;

class Package extends BasePackage
{
    protected $settings;

    public function __construct(Data $package, $package_type = null)
    {
        $data = new Data($package->blueprints()->toArray());
        parent::__construct($data, $package_type);

        $this->settings = $package->toArray();

        $html_description = Parsedown::instance()->line($this->__get('description'));
        $this->data->set('slug', $package->__get('slug'));
        $this->data->set('description_html', $html_description);
        $this->data->set('description_plain', strip_tags($html_description));
        $this->data->set('symlink', is_link(USER_DIR . $package_type . DS . $this->__get('slug')));
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->settings['enabled'];
    }
}

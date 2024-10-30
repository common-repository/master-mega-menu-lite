<div class="jltma-pop-contents-body">
    <div class="jltma-pop-contents-padding">

        <div class="modal-header">
            <ul class="nav nav-tabs jltma_menu_control_nav" role="tablist">
                <li role="presentation" id="content_nav" class="nav-item">
                    <a class="nav-link active"
                        href="#content_tab"
                        aria-controls="content_tab"
                        role="tab"
                        aria-selected="true"
                        data-toggle="tab">
                        <?php esc_html_e('Content', 'master-mega-menu-lite'); ?>
                    </a>
                </li>

                <li role="presentation" id="general_nav"  class="nav-item">
                    <a
                        class="nav-link"
                        href="#general_tab"
                        aria-controls="general_tab"
                        role="tab"
                        aria-selected="false"
                        data-toggle="tab">
                        <?php esc_html_e('Settings', 'master-mega-menu-lite'); ?>

                    </a>
                </li>

                <li role="presentation" id="icon_nav"  class="nav-item">
                    <a
                        class="nav-link"
                        href="#icon_tab"
                        aria-controls="icon_tab"
                        role="tab"
                        aria-selected="false"
                        data-toggle="tab">
                        <?php esc_html_e('Icon', 'master-mega-menu-lite'); ?>

                    </a>
                </li>

                <li role="presentation" id="badge_nav"  class="nav-item">
                    <a
                        class="nav-link"
                        href="#badge_tab"
                        aria-controls="badge_tab"
                        role="tab"
                        aria-selected="false"
                        data-toggle="tab">
                        <?php esc_html_e('Badge', 'master-mega-menu-lite'); ?>

                    </a>
                </li>

            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="content_tab" aria-labelledby="content-tab">
                    <?php if(defined( 'ELEMENTOR_VERSION' )): ?>

                    <div class="jltma-pop-content-inner">

                        <div id="jltma-menu-builder-wrapper">

                            <div class="custom-control custom-switch">
                                <span class="switch-title jltma-menu-mega-submenu enabled_item">
                                    <?php esc_html_e('Megamenu Enabled'); ?>
                                </span>
                                <span class="switch-title jltma-menu-mega-submenu disabled_item">
                                    <?php esc_html_e('Megamenu Disabled'); ?>
                                </span>

                                <label for="jltma-menu-item-enable" class="switch">
                                    <input type="checkbox" value="1" id="jltma-menu-item-enable" />
                                    <span class="slider round"></span>
                                    <span class="absolute-no"><?php esc_html_e('NO'); ?></span>
                                </label>
                            </div>


                            <button
                                disabled type="button"
                                id="jltma-menu-builder-trigger"
                                class="jltma-menu-elementor-button content-edit-btn"
                                data-toggle="modal"
                                data-target="#jltma-mega-menu-builder-modal">
                                <?php esc_html_e('Edit Megamenu Content'); ?>
                            </button>

                        </div>


                    </div>


                    <?php else: ?>
                    <p class="no-elementor-notice">
                        <?php esc_html_e( 'Elementor Page Builder required to Edit Megamenu Content', 'master-mega-menu-lite' ); ?>
                    </p>
                    <?php endif; ?>
                </div>


                <div role="tabpanel" class="tab-pane" id="general_tab" aria-labelledby="general-tab">

                    <div class="option-table jltma-label-container">
                        <div class="row">

                            <div class="form-group mb-2 col-7">
                                <label for="jltma-mobile-submenu-type">
                                    <strong>
                                        <?php esc_html_e('Mobile Menu', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-5">
                                <select class="form-control" id="jltma-mobile-submenu-type">
                                    <option value="submenu_list"><?php esc_html_e('WP Menu List', 'master-mega-menu-lite'); ?></option>
                                    <option value="builder_content" selected="selected"><?php esc_html_e('Builder Content', 'master-mega-menu-lite'); ?></option>
                                </select>
                            </div>

                            <div class="form-group mb-2 col-7">
                                <label for="mega-menu-trigger-effect">
                                    <strong>
                                        <?php esc_html_e('Trigger Effect', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-5">
                                <select class="form-control" id="mega-menu-trigger-effect">
                                    <option value="" selected="selected"><?php esc_html_e('Hover', 'master-mega-menu-lite'); ?></option>
                                    <option value="click"><?php esc_html_e('Click', 'master-mega-menu-lite'); ?></option>
                                </select>
                            </div>


                            <div class="form-group mb-2 col-8 jltma-disabled">
                                <label for="mega-menu-hide-item-label">
                                    <strong>
                                        <?php esc_html_e('Show Menu Label', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-4 jtlma-mega-switcher jltma-disabled">
                                <input type='checkbox' id="mega-menu-hide-item-label" class='mega-menu-hide-item-label' name='mega-menu-hide-item-label' value='1'/>
                                <label for="mega-menu-hide-item-label">
                                    <?php _e("NO", 'master-mega-menu-lite') ?>
                                </label>
                            </div>

                            <span class="jltma-pro-badge eicon-pro-icon"></span>

                            <div class="form-group mb-2 col-8 jltma-disabled">
                                <label for="mega-menu-hide-item-label">
                                    <strong>
                                        <?php esc_html_e('Show Description', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-4 jtlma-mega-switcher jltma-disabled">
                                <input type='checkbox' id="jltma-menu-disable-description" class='jltma-menu-disable-description' name='jltma-menu-disable-description' value='1'/>
                                <label for="jltma-menu-disable-description">
                                    <?php _e("NO", 'master-mega-menu-lite') ?>
                                </label>
                            </div>


                        </div>
                    </div>

                </div>


                <div role="tabpanel" class="tab-pane" id="icon_tab" aria-labelledby="icon-tab">

                    <div class="option-table jltma-label-container">
                        <div class="row">

                            <div class="form-group mb-2 col-7 jltma-disabled">
                                <label for="jltma-menu-icon-field">
                                    <strong>
                                        <?php esc_html_e('Menu Icon', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>

                            <div class="form-group mb-2 col-5">
                                <div data-target="icon-picker" class="button icon-picker"></div>
                                <input id="jltma-menu-icon-field" class="icon-picker-input jltma-disabled" type="text" placeholder="Click Icon for Picker" />
                            </div>

                            <span class="jltma-pro-badge pt-0 eicon-pro-icon"></span>

                            <div class="form-group mb-2 col-7 jltma-disabled">
                                <label for="jltma-menu-icon-color-field">
                                    <strong>
                                        <?php esc_html_e('Icon Color', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-5 jltma-disabled">
                                <input type="text" value="#6f10b5" class="jltma-menu-wpcolor-picker jltma-disabled" id="jltma-menu-icon-color-field" />
                            </div>


                        </div>
                    </div>


                </div>


                <div role="tabpanel" class="tab-pane" id="badge_tab" aria-labelledby="badge-tab">
                    <div class="option-table jltma-label-container">
                        <div class="row">

                            <div class="form-group mb-2 col-7">
                                <label for="jltma-menu-badge-text-field">
                                    <strong>
                                        <?php esc_html_e('Badge Text', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-5">
                                <input type="text" placeholder="<?php esc_html_e('Badge Text', 'master-mega-menu-lite'); ?>" id="jltma-menu-badge-text-field" />
                            </div>


                            <span class="jltma-pro-badge pt-5 eicon-pro-icon"></span>

                            <div class="form-group mb-2 col-7 jltma-disabled">
                                <label for="jltma-menu-badge-color-field">
                                    <strong>
                                        <?php esc_html_e('Badge Color', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-5 jltma-disabled">
                                <input type="text" class="jltma-menu-wpcolor-picker jltma-disabled" value="#6f10b5"
                                        id="jltma-menu-badge-color-field" />
                            </div>

                            

                            <div class="form-group mb-2 col-7 jltma-disabled">
                                <label for="jltma-menu-badge-background-field">
                                    <strong>
                                        <?php esc_html_e('Background', 'master-mega-menu-lite'); ?>
                                    </strong>
                                </label>
                            </div>
                            <div class="form-group mb-2 col-5 jltma-disabled">
                                <input type="text" class="jltma-menu-wpcolor-picker jltma-disabled" value="#6f10b5"
                                    id="jltma-menu-badge-background-field" />
                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>
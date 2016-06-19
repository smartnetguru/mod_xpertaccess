<?php
/**
 * @package XpertAccess
 * @version 3.2
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$usersConfig = JComponentHelper::getParams('com_users');
?>

<!--ThemeXpert: Xpert Access Module Start-->

<!-- Links start -->
<div id="xa-links">
    <?php if( $type == 'logout' ):?>

    <a class="xa-btn <?php echo $params->get('login_btn_class');?>" data-toggle="modal" href="#xa-login" title="<?php echo JText::_('XA_LOGOUT')?>"><?php echo JText::_('XA_LOGOUT')?></a>
    
    <?php else: ?>

    <div class="xa-btn-group">
        <?php if($params->get('enable_login',1)):?>
            <a class="xa-btn <?php echo $params->get('login_btn_class');?>" data-toggle="modal" href="#xa-login" title="<?php echo $params->get('login_text');?>"><?php echo $params->get('login_text');?></a>
        <?php endif; ?>

        <?php if( $params->get('enable_registration',0) AND $usersConfig->get('allowUserRegistration') ):?>
            <a class="xa-btn <?php echo $params->get('registration_btn_class');?>" data-toggle="modal" href="#xa-registration" title="<?php echo $params->get('registration_text');?>"><?php echo $params->get('registration_text');?></a>
        <?php endif;?>
    </div>
    <?php endif;?>
</div>
<!-- Links end -->

<!-- Login form start -->
<div id="xa-login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

        <?php if ($type == 'logout') : ?>
            <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="xa-login-form">

                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>
                    <h3 class="modal-title"><?php echo JText::_('JLOGOUT'); ?></h3>
                </div>

                <div class="modal-body">
                    <?php if ($params->get('greeting')) : ?>
                        <div class="login-greeting">
                        <?php if($params->get('name') == 0) : {
                            echo JText::sprintf('XA_HINAME', htmlspecialchars($user->get('name')));
                        } else : {
                            echo JText::sprintf('XA_HINAME', htmlspecialchars($user->get('username')));
                        } endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="modal-footer">
                    <input type="submit" name="Submit" class="xa-btn xa-btn-primary" value="<?php echo JText::_('JLOGOUT'); ?>" />
                    <?php echo JText::_('XA_USERS_OR');?>
                    <input type="hidden" name="option" value="com_users" />
                    <input type="hidden" name="task" value="user.logout" />
                    <input type="hidden" name="return" value="<?php echo $return; ?>" />
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </form>

        <?php else:?>
        <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="xa-login-form" class="form-horizontal">
          
          <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3 class="modal-title"><?php echo $params->get('login_title')?></h3>
          </div>
          
          <div class="modal-body">

            <?php if ($params->get('pretext')): ?>
                <div class="pretext xa-callout <?php echo $params->get('pretext_type');?>">
                    <p><?php echo $params->get('pretext'); ?></p>
                </div>
            <?php endif; ?>

            <div class="control-group">
                <label class="control-label" for="xa-username"><?php echo JText::_('JGLOBAL_USERNAME') ?></label>
                <div class="controls">
                  <input id="xa-username" type="text" name="username" class="inputbox" placeholder="<?php echo JText::_('JGLOBAL_USERNAME') ?>" /> <br />
                  <a class="help-block" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"> <?php echo JText::_('XA_USERS_LOGIN_REMIND'); ?></a>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="xa-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
                <div class="controls">
                  <input id="xa-passwd" type="password" name="password" class="inputbox" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>"  /> <br />
                  <a class="help-block" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"> <?php echo JText::_('XA_USERS_LOGIN_RESET'); ?></a>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                    <label class="checkbox">
                        <input id="xa-remember" type="checkbox" name="remember" class="inputbox" value="yes"/> <?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>
                    </label>
                <?php endif;?>
                </div>
            </div>

            <?php if ($params->get('posttext')): ?>
                <div class="posttext xa-callout <?php echo $params->get('posttext_type');?>">
                <p><?php echo $params->get('posttext'); ?></p>
                </div>
            <?php endif; ?>
          </div>

              <div class="modal-footer">
                <input type="submit" name="Submit" class="xa-btn xa-btn-primary" value="<?php echo JText::_('JLOGIN') ?>" />
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="user.login" />
                <input type="hidden" name="return" value="<?php echo $return; ?>" />
                <?php echo JHtml::_('form.token'); ?>
              </div>
          </form>
        <?php endif;?>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- Login form end -->

<!-- Registration for start -->
<?php if( $usersConfig->get('allowUserRegistration') AND $type != 'logout' ):?>    
<div id="xa-registration" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="xa-member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal">

                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>
                    <h3 class="modal-title"><?php echo $params->get('registration_title');?></h3>
                </div>
                
                <div class="modal-body">
                    <span class="spacer"><span class="before"></span><span class="text"><label class="" id="jform_spacer-lbl"><strong class="red">*</strong> Required field</label></span><span class="after"></span></span>

                    <div class="control-group">
                        <label class="control-label hasTip required" for="jform_name" id="jform_name-lbl"><?php echo JText::_('XA_VALUE_NAME')?>:<span class="star">&nbsp;*</span></label>
                        
                        <div class="controls">
                          <input type="text" class="required" value="" id="jform_name" name="jform[name]" placeholder="<?php echo JText::_('XA_VALUE_NAME')?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label title="" class="control-label hasTip required" for="jform_username" id="jform_username-lbl"><?php echo JText::_('JGLOBAL_USERNAME') ?><span class="star">&nbsp;*</span></label>
                        <div class="controls">
                          <input type="text" class="validate-username required" value="" id="jform_username" name="jform[username]" placeholder="<?php echo JText::_('JGLOBAL_USERNAME') ?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label title="" class="control-label hasTip required" for="jform_password1" id="jform_password1-lbl"><?php echo JText::_('JGLOBAL_PASSWORD') ?><span class="star">&nbsp;*</span></label>
                        <div class="controls">
                          <input type="password" class="validate-password required" autocomplete="off" value="" id="jform_password1" name="jform[password1]" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label title="" class="control-label hasTip required" for="jform_password2" id="jform_password2-lbl"><?php echo JText::_('XA_CONFIRM_PASSWORD')?>:<span class="star">&nbsp;*</span></label>
                        <div class="controls">
                          <input type="password" size="30" class="validate-password required" autocomplete="off" value="" id="jform_password2" name="jform[password2]" placeholder="Confirm password">
                        </div>
                    </div>

                    <div class="control-group">
                        <label title="" class="control-label hasTip required" for="jform_email1" id="jform_email1-lbl"><?php echo JText::_('XA_EMAIL')?>:<span class="star">&nbsp;*</span></label>
                        <div class="controls">
                          <input type="text" value="" id="jform_email1" class="validate-email required" name="jform[email1]" placeholder="demo@test.com">
                        </div>
                    </div>  

                    <div class="control-group">
                        <label title="" class="control-label hasTip required" for="jform_email2" id="jform_email2-lbl"><?php echo JText::_('XA_CONFIRM_EMAIL')?>:<span class="star">&nbsp;*</span></label> 
                        <div class="controls">
                          <input type="text" size="30" value="" id="jform_email2" class="validate-email required" name="jform[email2]" placeholder="demo@test.com">
                        </div>
                    </div>  
                </div>

                <div class="modal-footer">
                    <input type="submit" class="validate xa-btn xa-btn-primary" value="<?php echo JText::_('JREGISTER');?>" />
                    <input type="hidden" name="option" value="com_users" class="" aria-invalid="false">
                    <input type="hidden" name="task" value="registration.register" class="" aria-invalid="false">
                    <?php echo JHtml::_('form.token');?>
                </div>

            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- Registration form end -->

<!--ThemeXpert: Xpert Access Module end-->
<?php
/**
 * @package   AkeebaLoginGuard
 * @copyright Copyright (c)2016-2017 Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

// Prevent direct access
defined('_JEXEC') or die;

/** @var LoginGuardViewMethods $this */

JHtml::_('bootstrap.tooltip');

/** @var LoginGuardModelMethods $model */
$model = $this->getModel();

?>
<div id="loginguard-methods-list">
    <div id="loginguard-methods-reset-container" class="well well-large well-lg col-sm-6 col-sm-offset-3 span6 offset3">
		<?php if ($this->tfaActive): ?>
            <a href="<?php echo JRoute::_('index.php?option=com_loginguard&task=methods.disable&' . JFactory::getSession()->getToken() . '=1' . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id) ?>"
               class="btn btn-danger pull-right">
				<?php echo JText::_('COM_LOGINGUARD_LBL_LIST_REMOVEALL'); ?>
            </a>
		<?php endif; ?>
        <span id="loginguard-methods-reset-message">
            <?php echo JText::sprintf('COM_LOGINGUARD_LBL_LIST_STATUS', JText::_('COM_LOGINGUARD_LBL_LIST_STATUS_' . ($this->tfaActive ? 'ON' : 'OFF'))) ?>
        </span>
    </div>

    <div class="clearfix"></div>

    <?php if (!$this->isAdmin): ?>
	<h3 id="loginguard-methods-list-head">
		<?php echo JText::_('COM_LOGINGUARD_HEAD_LIST_PAGE'); ?>
	</h3>
	<?php endif; ?>
	<div id="loginguard-methods-list-instructions">
		<p>
            <span class="icon icon-info glyphicon glyphicon-info"></span>
			<?php echo JText::_('COM_LOGINGUARD_LBL_LIST_INSTRUCTIONS'); ?>
        </p>
	</div>

	<div id="loginguard-methods-list-container">
		<?php foreach($this->methods as $methodName => $method): ?>
		<div class="loginguard-methods-list-method loginguard-methods-list-method-name-<?php echo htmlentities($method['name'])?> <?php echo ($this->defaultMethod == $methodName) ? 'loginguard-methods-list-method-default' : ''?> ">
			<img
				class="loginguard-methods-list-method-image pull-left" src="<?php echo JUri::root() . $method['image'] ?>"
			>
			<h4 class="loginguard-methods-list-method-title">
				<?php echo $method['display'] ?>
                <?php if ($this->defaultMethod == $methodName): ?>
                <span id="loginguard-methods-list-method-default-tag" class="badge badge-info">
                    <?php echo JText::_('COM_LOGINGUARD_LBL_LIST_DEFAULTTAG') ?>
                </span>
                <?php endif; ?>
				<span class="hasTooltip icon icon-info-circle glyphicon glyphicon-info-sign pull-right"
				      title="<?php echo $this->escape($method['shortinfo']) ?>"></span>
			</h4>

            <div class="clearfix"></div>

			<div class="loginguard-methods-list-method-records-container">
				<?php if (count($method['active'])): ?>
					<div class="loginguard-methods-list-method-records">
						<?php  foreach($method['active'] as $record): ?>
							<div class="loginguard-methods-list-method-record">

                                <div class="row-fluid">
                                    <div class="loginguard-methods-list-method-record-title-container span10 col-sm-10">
		                                <?php if ($record->default): ?>
                                        <span id="loginguard-methods-list-method-default-badge-small" class="badge badge-info hasTooltip" title="<?php echo $this->escape(JText::_('COM_LOGINGUARD_LBL_LIST_DEFAULTTAG')) ?>">
                                            <span class="icon icon-star glyphicon glyphicon-star"></span>
                                        </span>
                                        <?php endif; ?>
                                        <span class="loginguard-methods-list-method-record-title">
                                            <?php echo $this->escape($record->title); ?>
                                        </span>
                                    </div>

                                    <div class="span2 col-sm-2 pull-right" style="margin-left: 0">
                                        <a href="<?php echo JRoute::_('index.php?option=com_loginguard&task=method.edit&id=' . (int) $record->id . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id)?>"
                                           class="loginguard-methods-list-method-record-edit"
                                        ><span class="icon icon-pencil glyphicon glyphicon-pencil"></span></a>
                                        <br/>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="loginguard-methods-list-method-record-lastused row-fluid">
                                    <div class="span10 col-sm-10">
                                        <span class="loginguard-methods-list-method-record-createdon">
                                            <?php echo JText::sprintf('COM_LOGINGUARD_LBL_CREATEDON', $model->formatRelative($record->created_on)) ?>
                                        </span>
                                        <span class="loginguard-methods-list-method-record-lastused-date">
                                            <?php echo JText::sprintf('COM_LOGINGUARD_LBL_LASTUSED', $model->formatRelative($record->last_used)) ?>
                                        </span>
                                        <span class="loginguard-methods-list-method-record-lastused-location">
                                            <?php echo $model->formatBrowser($record->ua) ?>
                                            <?php echo $model->formatIp($record->ip) ?>
                                        </span>
                                    </div>
	                                <?php if ($method['canDisable']): ?>
                                    <span class="span2 col-sm-2 pull-right" style="margin-left: 0">
                                        <a href="<?php echo JRoute::_('index.php?option=com_loginguard&task=method.delete&id=' . (int) $record->id  . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id)?>"
                                           class="loginguard-methods-list-method-record-delete"
                                        ><span class="icon icon-trash glyphicon glyphicon-trash"></span></a>
                                    </span>
	                                <?php endif; ?>
                                </div>
                            </div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if (empty($method['active']) || $method['allowMultiple']): ?>
					<div class="loginguard-methods-list-method-addnew-container">
						<a href="<?php echo JRoute::_('index.php?option=com_loginguard&task=method.add&method=' . $this->escape(urlencode($method['name'])) . ($this->returnURL ? '&returnurl=' . $this->escape(urlencode($this->returnURL)) : '') . '&user_id=' . $this->user->id)?>"
						   class="loginguard-methods-list-method-addnew"
						>
							<?php echo JText::sprintf('COM_LOGINGUARD_LBL_LIST_ADD_A', $method['display']) ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
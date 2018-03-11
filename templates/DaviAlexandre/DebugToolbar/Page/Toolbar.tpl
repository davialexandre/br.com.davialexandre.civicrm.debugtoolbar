<div id="da-debug-toolbar">
  {assign var=collectors value=$profile->getCollectors()}
  {foreach from=$templates key=collectorName item=collectorTemplates}
    {include file=$collectorTemplates.toolbar collector=$collectors.$collectorName profileID=$profile->getIdentifier()}
  {/foreach}
  <div class="da-toolbar-toggle-button da-toolbar-close-button"><i class="fa fa-chevron-right" /></div>
  <div class="da-toolbar-toggle-button da-toolbar-open-button"><i class="fa fa-chevron-left" /></div>
</div>

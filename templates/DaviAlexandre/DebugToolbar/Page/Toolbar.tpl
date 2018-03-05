<div id="da-debug-toolbar">
  {foreach from=$templates key=collectorName item=collectorTemplates}
    {include file=$collectorTemplates.toolbar collector=$collectors.$collectorName}
  {/foreach}
  <div class="da-toolbar-toggle-button da-toolbar-close-button"><i class="fa fa-chevron-right" /></div>
  <div class="da-toolbar-toggle-button da-toolbar-open-button"><i class="fa fa-chevron-left" /></div>
</div>

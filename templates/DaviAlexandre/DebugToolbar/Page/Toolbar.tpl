<div id="da-debug-toolbar">
  {foreach from=$templates key=collectorName item=collectorTemplates}
    {include file=$collectorTemplates.toolbar collector=$collectors.$collectorName}
  {/foreach}
</div>

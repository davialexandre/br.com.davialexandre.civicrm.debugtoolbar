<h3>Database Statistics</h3>
<div class="da-profile-stats">
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getNumberOfQueries()}
    </div>
    <div class="da-profile-stat-name">
      No. of queries
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getTotalTime()|string_format:"%.2f"} ms
    </div>
    <div class="da-profile-stat-name">
      Total Time
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getAverageQueryTime()|string_format:"%.2f"} ms
    </div>
    <div class="da-profile-stat-name">
      Average Query time
    </div>
  </div>
</div>

<h3>Queries</h3>
<table class="da-sortable-table">
  <thead>
  <tr>
    <th data-sort-default>#</th>
    <th>Class</th>
    <th>Query</th>
    <th class="no-wrap">No. of Rows</th>
    <th class="no-wrap">Time</th>
  </tr>
  </thead>
  <tbody>
  {foreach from=$collector->getQueries() item=query name=queries}
    <tr>
      <td>{$smarty.foreach.queries.iteration}</td>
      <td>{$query.class}</td>
      <td>
        <pre class="sql"><code>{$query.query|formatSQL}</code></pre>
        <span class="da-profile-cell-actions">
          <span class="da-profile-cell-action da-copy-sql">Copy to clipboard <i class="fa fa-copy"></i> </span>
        </span>
      </td>
      <td>{$query.rows}</td>
      <td class="no-wrap">{$query.time|string_format:"%.2f"} ms</td>
    </tr>
  {/foreach}
  </tbody>
</table>
<script type="text/javascript">
  {literal}
  new ClipboardJS('.da-copy-sql', {
    text: function(trigger) {
      return trigger.parentElement.parentElement.querySelector('code').innerText;
    }
  });
  {/literal}
</script>

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
<table>
  <thead>
  <tr>
    <th>#</th>
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
      <td>{$query.query}</td>
      <td>{$query.rows}</td>
      <td class="no-wrap">{$query.time|string_format:"%.2f"} ms</td>
    </tr>
  {/foreach}
  </tbody>
</table>

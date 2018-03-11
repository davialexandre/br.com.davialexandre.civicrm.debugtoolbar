<div class="da-toolbar-block da-toolbar-block-left">
  <a class="da-toolbar-profile-link" href="/civicrm/debug-toolbar/profile?id={$profile->getIdentifier()}&panel={$collector->getName()}">
    <span class="da-toolbar-value">
      <i class="fa fa-server"></i>{$collector->getNumberOfQueries()} in {$collector->getTotalTime()|string_format:"%.2f"} ms
    </span>
  </a>
  <div class="da-toolbar-details">
    <table>
      <tr>
        <td>No. of DB Queries</td>
        <td>{$collector->getNumberOfQueries()}</td>
      </tr>
      <tr>
        <td>Total time</td>
        <td>{$collector->getTotalTime()|string_format:"%.2f"} ms</td>
      </tr>
      <tr>
        <td>Average Query time</td>
        <td>{$collector->getAverageQueryTime()|string_format:"%.2f"} ms</td>
      </tr>
    </table>
  </div>
</div>

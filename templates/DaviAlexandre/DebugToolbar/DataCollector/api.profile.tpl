<h3>API Statistics</h3>
<div class="da-profile-stats">
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getNumberOfApiCalls()}
    </div>
    <div class="da-profile-stat-name">
      No. of API calls
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
      {$collector->getAverageCallTime()|string_format:"%.2f"} ms
    </div>
    <div class="da-profile-stat-name">
      Average call time
    </div>
  </div>
</div>

<h3>API Calls</h3>
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>API</th>
      <th>Count</th>
      <th>Time</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$collector->getApiCalls() item=apiCall name=apiCalls}
      <tr>
        <td>{$smarty.foreach.apiCalls.iteration}</td>
        <td>
          {$apiCall.entity}.{$apiCall.action}
          <span class="da-profile-api-actions">
            <span class="da-profile-show-params">Show params</span>
            <span class="da-profile-show-response">Show response</span>
          </span>
          <div class="da-profile-api-details da-profile-api-params">
            <pre>{php}$apiCall = $this->get_template_vars('apiCall'); print_r($apiCall['params']);{/php}</pre>
          </div>
          <div class="da-profile-api-details da-profile-api-response">
            <pre>{php}$apiCall = $this->get_template_vars('apiCall'); print_r($apiCall['response']);{/php}</pre>
          </div>
        </td>
        <td>{$apiCall.response.count}</td>
        <td>{$apiCall.time|string_format:"%.2f"} ms</td>
      </tr>
    {/foreach}
  </tbody>
</table>
<script type="text/javascript">
  {literal}
  $(document).ready(function() {
    $('.da-profile-show-params').on('click', function(event) {
      event.preventDefault();
      toggleDetails(this, '.da-profile-api-params', 'Show params', 'Hide params');
    });

    $('.da-profile-show-response').on('click', function(event) {
      event.preventDefault();
      toggleDetails(this, '.da-profile-api-response', 'Show response', 'Hide response');
    });

    function toggleDetails(actionElement, detailsSelector, showMessage, hideMessage) {
      if(actionElement.innerText == showMessage) {
        actionElement.innerText = hideMessage;
      } else {
        actionElement.innerText = showMessage;
      }

      $(actionElement).closest('td').find(detailsSelector).toggle();
    }
  });
  {/literal}
</script>

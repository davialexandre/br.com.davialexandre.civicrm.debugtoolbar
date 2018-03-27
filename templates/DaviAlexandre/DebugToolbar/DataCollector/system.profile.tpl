<h3>System Configuration</h3>
<div class="da-profile-stats">
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getPHPVersion()}
    </div>
    <div class="da-profile-stat-name">
      PHP
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getMySQLVersion()}
    </div>
    <div class="da-profile-stat-name">
      MySQL
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getWebserverSoftware()}
    </div>
    <div class="da-profile-stat-name">
      HTTP
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getOS()}
    </div>
    <div class="da-profile-stat-name">
      OS
    </div>
  </div>
</div>

<h3>PHP Configuration</h3>
<table class="da-sortable-table">
  <thead>
    <th>Configuration</th>
    <th>Value</th>
  </thead>
  <tbody>
    <tr>
      <td>SAPI</td>
      <td>{$collector->getPHPSapi()}</td>
    </tr>
    <tr>
      <td>Extensions</td>
      <td>{', '|implode:$collector->getPHPExtensions()}</td>
    </tr>
    {foreach from=$collector->getPHPConfiguration() item=value key=configuration}
      <tr>
        <td>{$configuration}</td>
        <td>{$value}</td>
      </tr>
    {/foreach}
  </tbody>
</table>

<h3>MySQL Variables</h3>
<table class="da-sortable-table">
  <thead>
  <th>Variable</th>
  <th>Value</th>
  </thead>
  <tbody>
  {foreach from=$collector->getMySQLVariables() item=value key=variable}
    <tr>
      <td>{$variable}</td>
      <td>{$value}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

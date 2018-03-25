<h3>CiviCRM Configuration</h3>
<div class="da-profile-stats">
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getVersion()}
    </div>
    <div class="da-profile-stat-name">
      CiviCRM version
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {if $collector->isDebugEnabled()}
        <i class="fa fa-check"></i>
      {else}
        <i class="fa fa-times"></i>
      {/if}
    </div>
    <div class="da-profile-stat-name">
      Debug
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {if $collector->isBacktraceEnabled()}
        <i class="fa fa-check"></i>
      {else}
        <i class="fa fa-times"></i>
      {/if}
    </div>
    <div class="da-profile-stat-name">
      Backtrace
    </div>
  </div>
  <div class="da-profile-stat">
    <div class="da-profile-stat-value">
      {$collector->getEnvironment()}
    </div>
    <div class="da-profile-stat-name">
      Environment
    </div>
  </div>
</div>

<h3>Paths</h3>
<table class="da-sortable-table">
  <thead>
  <tr>
    <th data-sort-default>Name</th>
    <th>Path</th>
  </tr>
  </thead>

  <tbody>
  <tr>
    <td>Root Directory</td>
    <td>{$collector->getRootDir()}</td>
  </tr>
  <tr>
    <td>Images Directory</td>
    <td>{$collector->getImagesDir()}</td>
  </tr>
  <tr>
    <td>Extensions Directory</td>
    <td>{$collector->getExtensionsDir()}</td>
  </tr>
  <tr>
    <td>Temporary Files Directory</td>
    <td>{$collector->getTemporaryFilesDir()}</td>
  </tr>
  <tr>
    <td>Custom Files Directory</td>
    <td>{$collector->getCustomFilesDir()}</td>
  </tr>
  </tbody>
</table>

<h3>Extensions</h3>
<table class="da-sortable-table">
  <thead>
  <tr>
    <th data-sort-default>Name (key)</th>
    <th>Version</th>
    <th>Schema Version</th>
    <th>Path</th>
    <th>Status</th>
  </tr>
  </thead>
  {foreach from=$collector->getExtensions() item=extension}
    <tr>
      <td><span class="da-profile-extension-name">{$extension.name}</span> <span class="da-profile-extension-key">({$extension.key})</span></td>
      <td>{$extension.version}</td>
      <td>{$extension.schemaVersion}</td>
      <td>{$extension.path}</td>
      <td class="{if $extension.status eq 'installed'}da-profile-extension-installed"{else}da-profile-extension-uninstalled{/if}">
        {$extension.status}
      </td>
    </tr>
  {/foreach}
</table>

<h3>Settings</h3>
<table class="da-sortable-table">
  <thead>
  <tr>
    <th data-sort-default>Name</th>
    <th>Value</th>
  </tr>
  </thead>
  {foreach from=$collector->getSettings() key=settingName item=setting}
    <tr>
      <td>{$settingName}</td>
      <td>
        <pre>{php}$var = $this->get_template_vars('setting'); print_r($var);{/php}</pre>
      </td>
    </tr>
  {/foreach}
</table>

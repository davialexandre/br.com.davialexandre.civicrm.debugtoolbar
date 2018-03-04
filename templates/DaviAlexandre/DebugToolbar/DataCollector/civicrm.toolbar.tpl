<div class="da-toolbar-block da-toolbar-block-right">
  <span class="da-toolbar-value"><span class="crm-logo-sm"></span>{$collector->getVersion()}</span>
  <div class="da-toolbar-details">
    <table>
      <tr>
        <td>No. of extensions</td>
        <td>{$collector->getNumberOfExtensions()}</td>
      </tr>
      <tr>
        <td>No. of installed extensions</td>
        <td>{$collector->getNumberOfInstalledExtensions()}</td>
      </tr>
      <tr>
        <td>No. of enabled components</td>
        <td>{$collector->getNumberOfEnabledComponents()}</td>
      </tr>
      <tr>
        <td>Debug</td>
        <td>
          {if $collector->isDebugEnabled()}
            <span class="da-toolbar-status da-toolbar-status-success">enabled</span>
          {else}
            <span class="da-toolbar-status da-toolbar-status-failure">disabled</span>
          {/if}
        </td>
      </tr>
      <tr>
        <td>Backtrace</td>
        <td>
          {if $collector->isBacktraceEnabled()}
            <span class="da-toolbar-status da-toolbar-status-success">enabled</span>
          {else}
            <span class="da-toolbar-status da-toolbar-status-failure">disabled</span>
          {/if}
        </td>
      </tr>

    </table>
    <table>
      <caption>Paths</caption>
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
    </table>
  </div>
</div>

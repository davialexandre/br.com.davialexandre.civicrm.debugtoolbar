<div class="da-toolbar-block da-toolbar-block-left">
  <a class="da-toolbar-profile-link" href="/civicrm/debug-toolbar/profile?id={$profile->getIdentifier()}&panel={$collector->getName()}">
    <span class="da-toolbar-value">
      <i class="fa fa-microchip"></i>
      {$collector->getMemory()|string_format:"%.1f"} MB
    </span>
  </a>
  <div class="da-toolbar-details">
    <table>
      <tr>
        <td>Peak memory usage</td>
        <td>{$collector->getMemory()|string_format:"%.1f"} MB</td>
      </tr>
      <tr>
        <td>PHP memory limit</td>
        <td>{$collector->getMemoryLimit()|string_format:"%.1f"} MB</td>
      </tr>
    </table>
  </div>
</div>

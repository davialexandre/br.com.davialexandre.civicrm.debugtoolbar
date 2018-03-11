<div class="da-toolbar-block da-toolbar-block-left">
  <a class="da-toolbar-profile-link" href="/civicrm/debug-toolbar/profile?id={$profile->getIdentifier()}&panel={$collector->getName()}">
    <span class="da-toolbar-value">
      <i class="fa fa-columns"></i>{$collector->getRenderTime()} ms
    </span>
  </a>
  <div class="da-toolbar-details">
    <table>
      <tr>
        <td>Class</td>
        <td>{$collector->getClass()}</td>
      </tr>
      <tr>
        <td>Render time</td>
        <td>{$collector->getRenderTime()} ms</td>
      </tr>
      <tr>
        <td>Type</td>
        <td>{$collector->getType()}</td>
      </tr>
    </table>
  </div>
</div>

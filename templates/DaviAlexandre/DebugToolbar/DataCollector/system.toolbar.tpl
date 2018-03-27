<div class="da-toolbar-block da-toolbar-block-right">
  <a class="da-toolbar-profile-link" href="/civicrm/debug-toolbar/profile?id={$profile->getIdentifier()}&panel={$collector->getName()}">
    <span class="da-toolbar-value"><i class="fa fa-cogs"></i>PHP {$collector->getPHPVersion()}</span>
  </a>
  <div class="da-toolbar-details">
    <table>
      <tr>
        <td>PHP</td>
        <td>{$collector->getPHPVersion()}</td>
      </tr>
      <tr>
        <td>MySQL</td>
        <td>{$collector->getMySQLVersion()}</td>
      </tr>
      <tr>
        <td>HTTP</td>
        <td>{$collector->getWebserverSoftware()}</td>
      </tr>
    </table>
  </div>
</div>

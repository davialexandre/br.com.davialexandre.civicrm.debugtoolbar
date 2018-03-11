<div class="da-toolbar-block da-toolbar-block-left">
  <a class="da-toolbar-profile-link" href="/civicrm/debug-toolbar/profile?id={$profile->getIdentifier()}&panel={$collector->getName()}">
    <span class="da-toolbar-value">
      <i class="fa fa-user"></i>{$collector->getUsername()}
    </span>
  </a>
  <div class="da-toolbar-details">
    <table>
      <tr>
        <td>Username</td>
        <td>{$collector->getUsername()} (ID: {$collector->getUserID()})</td>
      </tr>
      <tr>
        <td>Email</td>
        <td>{$collector->getUserEmail()}</td>
      </tr>
      {if $collector->getContactID() neq ''}
        <tr>
          <td>Contact name</td>
          {assign var="contactID" value=$collector->getContactID()}
          <td><a href="{crmURL p='civicrm/contact/view' q="reset=1&cid=`$contactID`"}">{$collector->getContactDisplayName()}</a> (ID: {$collector->getContactID()})</td>
        </tr>
      {/if}
    </table>
  </div>
</div>

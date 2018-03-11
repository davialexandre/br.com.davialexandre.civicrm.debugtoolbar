<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Debug Toolbar - Profile {$profile->getIdentifier()}</title>
  <link rel="stylesheet" href="{crmResURL ext="br.com.davialexandre.civicrm.debugtoolbar" file="css/profile.css"}">
  <link rel="stylesheet" href="/sites/all/modules/civicrm/bower_components/font-awesome/css/font-awesome.css">
  <script type="text/javascript" src="{crmResURL ext="br.com.davialexandre.civicrm.debugtoolbar" file="js/vendor/jquery-3.3.1.min.js"}"></script>
</head>
<body>
  <header id="da-profile-summary">
    <h1>Profile #{$profile->getIdentifier()}</h1>
    <p id="da-profile-url">Profiled URL: <a href="{$profile->getUrl()}">{$profile->getUrl()}</a></p>
    <ul id="da-profile-metadata">
      <li><span class="da-profile-metadata-label">Method</span>: {$profile->getMethod()}</li>
      {assign var=profileTime value=$profile->getTime()}
      <li><span class="da-profile-metadata-label">Profiled on</span>: {$profileTime->format('r')}</li>
      <li><span class="da-profile-metadata-label">Identifier</span>: {$profile->getIdentifier()}</li>
    </ul>
  </header>
  <div class="main">
    <nav id="da-profile-menu">
      {assign var=collectors value=$profile->getCollectors()}
      <ul>
        {foreach from=$templates key=collectorName item=collectorTemplates}
          {if $collectorTemplates.profile_menu_item}
            <li {if $selectedCollector eq $collectorName}class="da-profile-selected-menu-item"{/if}>
              {include file=$collectorTemplates.profile_menu_item
                       collector=$collectors.$collectorName
                       profileID=$profile->getIdentifier()
                       selectedCollector=$selectedCollector
              }
            </li>
          {/if}
        {/foreach}
      </ul>
    </nav>
    <article id="da-profile-collector">
      {include file=$templates.$selectedCollector.profile collector=$collectors.$selectedCollector}
    </article>
  </div>
</body>
</html>

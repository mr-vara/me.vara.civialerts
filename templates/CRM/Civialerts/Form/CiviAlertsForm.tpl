<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet" >
{* HEADER *}
<div style="background-color:#F6F6F2;padding:10px;font-family:'Titillium Web', serif">
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
  </div>
{/foreach}

{* FIELD EXAMPLE: OPTION 2 (MANUAL LAYOUT)

  <div>
    <span>{$form.favorite_color.label}</span>
    <span>{$form.favorite_color.html}</span>
  </div>

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
</div>
<div style="background-color:#F6F6F2;padding:10px;font-family:'Titillium Web', serif;margin-top:5px;font-size:15px;">
{$customContent}</div>
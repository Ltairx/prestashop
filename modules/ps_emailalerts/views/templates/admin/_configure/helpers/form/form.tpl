{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2015 PrestaShop SA
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* International Registered Trademark & Property of PrestaShop SA
*}

{extends file="helpers/form/form.tpl"}

{block name="input"}
    {if $input.type == 'switch' && $smarty.const._PS_VERSION_|@addcslashes:'\'' < '1.6'}
        {foreach $input.values as $value}
          <input type="radio" name="{$input.name|escape:'html':'UTF-8'}" id="{$value.id|intval}"
                 value="{$value.value|escape:'html':'UTF-8'}"
                 {if $fields_value[$input.name] == $value.value}checked="checked"{/if}
                  {if isset($input.disabled) && $input.disabled}disabled="disabled"{/if} />
          <label class="t" for="{$value.id|intval}">
              {if isset($input.is_bool) && $input.is_bool == true}
                  {if $value.value == 1}
                    <img src="../img/admin/enabled.gif" alt="{$value.label}"
                         title="{$value.label|escape:'html':'UTF-8'}"/>
                  {else}
                    <img src="../img/admin/disabled.gif" alt="{$value.label}"
                         title="{$value.label|escape:'html':'UTF-8'}"/>
                  {/if}
              {else}
                  {$value.label|escape:'html':'UTF-8'}
              {/if}
          </label>
          {if isset($input.br) && $input.br}<br/>{/if}
          {if isset($value.p) && $value.p}<p>{$value.p}</p>{/if}
        {/foreach}
    {elseif $input.type == 'emailalerts_tags'}
      {literal}
        <script type="text/javascript">
          $().ready(function () {
            var input_id = '{/literal}{if isset($input.id)}{$input.id}{else}{$input.name}{/if}{literal}';
            $('#' + input_id).tagify({delimiters: [13, 44], addTagPrompt: '{/literal}{l s='Add email' mod='ps_emailalerts' js=1}{literal}'});
            $({/literal}'#{$table}{literal}_form').submit(function () {
              $(this).find('#' + input_id).val($('#' + input_id).tagify('serialize'));
            });
          });
        </script>
      {/literal}
      {assign var='value_text' value=$fields_value[$input.name]}
      <input type="text"
           name="{$input.name}"
           id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
           value="{if isset($input.string_format) && $input.string_format}{$value_text|string_format:$input.string_format|escape:'html':'UTF-8'}{else}{$value_text|escape:'html':'UTF-8'}{/if}"
           class="{if isset($input.class)}{$input.class}{/if} tagify" autocomplete="off"
            {if isset($input.placeholder) && $input.placeholder } placeholder="{$input.placeholder}"{/if}
      />
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

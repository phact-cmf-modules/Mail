{extends 'mail/base.tpl'}

{block 'content'}
    {block 'title'}
        {add $title = ''}
        {if $title}
            <h1 style="color: black; font-family: Arial; font-size: 30px;">{$title}</h1>
        {/if}
    {/block}

    {block 'fields'}
        {add $fields = $model->getFieldsList()}
        {add $excluded = ['lft', 'rgt', 'root', 'depth']}
        {add $emptyValue = ''}

        {foreach $fields as $fieldName}
            {set $field = $model->getField($fieldName)}
            {if $field and $field->getValue() and !is_array($field->getValue())}
                {set $label = $field->label}
                {if !$label}
                    {set $label = $fieldName}
                {/if}
                {if $label == 'id'}
                    {set $label = $.t('Mail.main', 'Number / ID')}
                {/if}

                <table width="100%">
                    <tr>
                        <td width="50%">
                            <span style="color: black; font-weight: bold; font-family: Arial; color: black; font-size: 14px;">{$label}:</span>
                        </td>
                        <td width="50%">
                            {if $.php.is_a($field, '\Phact\Orm\Fields\FileField')}
                                {if $field->getUrl()}
                                    <a href="{$hostInfo}{$field->getUrl()}" style="color: black; font-size: 14px; font-family: Arial;">
                                        {t 'Mail.main' 'Download'}
                                    </a>
                                {else}
                                    {$emptyValue}
                                {/if}
                            {elseif $.php.is_a($field, '\Phact\Orm\Fields\DateField')}
                                {set $format = "d.m.Y"}
                                {if $.php.is_a($field, '\Phact\Orm\Fields\TimeField')}
                                    {set $format = "H:i:s"}
                                {elseif $.php.is_a($field, '\Phact\Orm\Fields\DateTimeField')}
                                    {set $format = "d.m.Y H:i:s"}
                                {/if}

                                {if $field->getValue()}
                                    {$field->getValue()|date:$format}
                                {else}
                                    {$emptyValue}
                                {/if}
                            {elseif $.php.is_a($field, '\Phact\Orm\Fields\BooleanField')}
                                {if $field->getValue()}
                                    {t 'Mail.main' 'Yes'}
                                {else}
                                    {t 'Mail.main' 'No'}
                                {/if}
                            {else}
                                {set $value = $field->getValue()}
                                {if $value}
                                    {if !$.php.is_array($value)}
                                        {if $.php.is_a($value, "\Phact\Orm\Model") && $.php.method_exists($value, 'getAbsoluteUrl')}
                                            <a href="{$hostInfo}{$value->getAbsoluteUrl()}">
                                                {$value}
                                            </a>
                                        {else}
                                            {$value}
                                        {/if}
                                    {/if}
                                {else}
                                    {$emptyValue}
                                {/if}
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" height="3"></td>
                    </tr>
                </table>
            {/if}
        {/foreach}
    {/block}

    {block 'afterFields'}
    {/block}
{/block}

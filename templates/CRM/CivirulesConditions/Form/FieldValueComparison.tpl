<h3>{$ruleConditionHeader}</h3>
<div class="crm-block crm-form-block crm-civirule-rule_condition-block-field-value-comparison">
    <div class="crm-section">
        <div class="label">{$form.entity.label}</div>
        <div class="content">{$form.entity.html}</div>
        <div class="clear"></div>
    </div>
    <div class="crm-section">
        <div class="label">{$form.field.label}</div>
        <div class="content">{$form.field.html}</div>
        <div class="clear"></div>
    </div>
    <div class="crm-section">
        <div class="label">{$form.operator.label}</div>
        <div class="content">{$form.operator.html}</div>
        <div class="clear"></div>
    </div>
    <div class="crm-section" id="value_parent">
        <div class="label">{$form.value.label}</div>
        <div class="content">{$form.value.html}</div>
        <div class="clear"></div>
    </div>
    <div class="crm-section" id="multi_value_parent">
        <div class="label">{$form.multi_value.label}</div>
        <div class="content">
            {$form.multi_value.html}
            <p class="description">{ts}Seperate each value on a new line{/ts}</p>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
{include file="CRM/CivirulesConditions/Form/ValueComparisonJs.tpl"}

{literal}
<script type="text/javascript">
    cj(function() {
        var all_fields = cj('#field').html();

        cj('#entity').change(function() {
           var val = cj('#entity').val();
            cj('#field').html(all_fields);
            cj('#field option').each(function(index, el) {
                if (cj(el).val().indexOf(val+'_') != 0) {
                    cj(el).remove();
                }
            });
        });
        cj('#entity').trigger('change');
    });
</script>
{/literal}
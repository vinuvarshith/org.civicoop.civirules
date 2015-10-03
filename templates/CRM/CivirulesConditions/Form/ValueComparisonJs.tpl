{literal}
<script type="text/javascript">
    cj(function() {
       cj('#operator').change(function() {
           var val = cj('#operator').val();
           switch (val) {
               case 'is one of':
               case 'is not one of':
                   cj('#multi_value_parent').removeClass('hiddenElement');
                   cj('#value_parent').addClass('hiddenElement');
                   break;
               default:
                   cj('#multi_value_parent').addClass('hiddenElement');
                   cj('#value_parent').removeClass('hiddenElement');
                   break;
           }
       });
        cj('#operator').trigger('change');
    });


    function retrieveOptionsForEntityAndField(entity, field) {
        cj('#multi_value_options').html('');
        cj('#value_options').html('');
        cj('#multi_value_options').addClass('hiddenElement');
        cj('#multi_value_parent .content.textarea').removeClass('hiddenElement');
        cj('#value_options').addClass('hiddenElement');
        cj('#value').removeClass('hiddenElement');
        cj('#operator option').removeClass('hiddenElement');

        CRM.api3(entity, 'getoptions', {'sequential': 1, 'field': field}, true)
        .done(function(data) {
            if (data.is_error) {
                return;
            }

            cj('#operator option[value=">"').addClass('hiddenElement');
            cj('#operator option[value=">="').addClass('hiddenElement');
            cj('#operator option[value="<"').addClass('hiddenElement');
            cj('#operator option[value="<="').addClass('hiddenElement');
            if (cj('#operator option:selected').hasClass('hiddenElement')) {
                cj('#operator').val('=');
            }

            var select_html = '';
            var html = '';
            var currentOptions = cj('#multi_value').val().match(/[^\r\n]+/g);
            var selectedOptions = new Array();
            var currentSelect = cj('#value').val();
            var newValueValue = '';
            if (!currentOptions) {
                currentOptions = new Array();
            }
            cj.each(data.values, function(key, value) {
                var selected = '';
                var checked = '';
                if (currentOptions.indexOf(value.key) >= 0) {
                    checked = 'checked="checked"';
                    selectedOptions[selectedOptions.length] = value.key;
                }
                if (value.key == currentSelect) {
                    selected='selected="selected"';
                    newValueValue = value.key;
                }
                var option = '<input type="checkbox" value="'+value.key+'" '+checked+'>'+value.value+'<br>';
                var select_option = '<option value="'+value.key+'" '+selected+'>'+value.value+'</option>';
                html = html + option;
                select_html = select_html + select_option;
            });
            if (html.length > 0) {
                cj('#multi_value').val(selectedOptions.join('\r\n'));
                cj('#multi_value_options').html(html);
                cj('#multi_value_options').removeClass('hiddenElement');
                cj('#multi_value_options input[type="checkbox"]').change(function() {
                    var currentOptions = cj('#multi_value').val().match(/[^\r\n]+/g);
                    if (!currentOptions) {
                        currentOptions = new Array();
                    }
                    var value = cj(this).val();
                    var index = currentOptions.indexOf(value);
                    if (this.checked) {
                        if (index < 0) {
                            currentOptions[currentOptions.length] = value;
                            cj('#multi_value').val(currentOptions.join('\r\n'));
                        }
                   } else {

                        if (index >= 0) {
                            currentOptions.splice(index, 1);
                            cj('#multi_value').val(currentOptions.join('\r\n'));
                        }
                    }
                });
                cj('#multi_value_parent .content.textarea').addClass('hiddenElement');
            } else {
                cj('#multi_value_parent .content.textarea').removeClass('hiddenElement');
            }
            if (select_html.length > 0) {
                cj('#value').val(newValueValue);
                cj('#value_options').html(select_html);
                cj('#value_options').removeClass('hiddenElement');
                cj('#value_options').change(function() {
                    var value = cj(this).val();
                    cj('#value').val(value);
                });
                cj('#value').addClass('hiddenElement');
            } else {
                cj('#value').removeClass('hiddenElement');
            }
        });
    }
</script>
{/literal}
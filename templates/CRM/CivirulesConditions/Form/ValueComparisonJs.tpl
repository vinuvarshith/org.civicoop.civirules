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
</script>
{/literal}
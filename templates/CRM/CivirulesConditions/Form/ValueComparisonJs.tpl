{literal}
<script type="text/javascript">
    cj(function() {
       cj('#operator').change(function() {
           var val = cj('#operator').val();
           switch (val) {
               case 'is one of':
               case 'is not one of':
                   cj('#multi_value').parent().parent().parent().parent().removeClass('hiddenElement');
                   cj('#value').parent().parent().addClass('hiddenElement');
                   break;
               default:
                   cj('#multi_value').parent().parent().parent().parent().addClass('hiddenElement');
                   cj('#value').parent().parent().removeClass('hiddenElement');
                   break;
           }
       });

        cj('#operator').trigger('change');
    });
</script>
{/literal}


  function changeTab(idTab)
  {
        $('[id^="onglet-"]').addClass('inactivee');
        $('#'+idTab).removeClass('inactivee');
        $('#'+idTab).addClass('activee');        
  }


  function set_quantity(el)
  {
    var ptype = $(el).attr('id').split('_').pop();
    var input = $('#qte_' + ptype);

    var current_value = parseInt(input.val());

    if ($(el).hasClass('minus') && current_value > 0 ){
        current_value -= 1;
    }

    if ($(el).hasClass('plus') && current_value >= 0 &&current_value <99){
        current_value +=1;
    }

    $(input).val(current_value);
  }

function addCart()
{
    var uri = $('.addcart').attr('route');

        $.ajax({
              type: "GET",
              url: uri,
              data: '',
              cache: false,
              success: function(data){
                $('#result').hide();
                 $('#result_price').html(data);
                 $('.modal_title').html("Vous venez d'ajouter au panier le(s) produit(s) suivant(s)")
                 $('.modal_title').addClass('text-success')
              },
              error: function(){
                alert('No data found');
              },
              complete: function(){
                $('#result').modal() ;

              }
          });
    
}

function customize()
{
    console.debug(this);
    var uri = $('.customize').attr('route');
    //var uri = $('.customize').attr('route');

        $.ajax({
              type: "GET",
              url: uri,
              data: '',
              cache: false,
              success: function(data){
                $('#result').hide();
                 $('.modal-body').html(data);
                 $('.modal_title').html($('.customize').attr('modal-title') + "TOTO");
                 $('.modal-footer').html( '        <button class="more_purchase">Annuler</button>        <button class="button_show_cart">Valider</button>'   );
              },
              error: function(){
                alert('No data found');
              },
              complete: function(){
                $('#result').modal() ;

              }
          });
    
}
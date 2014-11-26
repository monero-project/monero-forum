var sys = arbor.ParticleSystem(0, 0, 0);
sys.parameters({gravity:true});
sys.renderer = Renderer("#viewport") ;

sys.addNode('me', {'color':'red','shape':'box','label':$('#username').text().trim()});

var jqxhr = $.getJSON( "/keychain/trust/2/"+$('#user_id').text().trim(), function() {
  console.log( "JSON Called" );
}).done(function(data) {
  $.each(data, function(i, item) {
      sys.addNode(i, {'color':'orange','shape':'box','label': i});
      sys.addEdge('me', i);
      $.each(item, function(k, r_item)
        {
          sys.addNode(k, {'color':'orange','shape':'box','label': k});
          sys.addEdge(k, i);
        });
    }); 
})
.fail(function() {
  console.log( "JSON Trust Error" );
});




$(function(){
      // bind change event to select
      $('.select').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
              
          }
          return false;
      });
    });


// ...................Map google.............................................


function initMap(){
    // mofication des aspects de la carte
    var map = new google.maps.Map(document.getElementById("gmap"), {
        zoom: 13,
        center: new google.maps.LatLng(50.667815, 4.588646),
        streetViewControl: true,
        mapTypeIds: google.maps.MapTypeId.HYBRID,
        mapTypeId: 'hybrid',
        disableDefaultUI: false,
        fullscreenControl : true,
        styles: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#000000'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#e59400'}]
            },
            
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#e85113'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#13310c'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#0059b2'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#0080ff'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#0080ff'}]
            },



{
        featureType: "landscape",
        elementType: "all",
        stylers: [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        featureType: "landscape",
        elementType: "geometry",
        stylers: [
            {
                "visibility": "on"
            }
        ]
    },
    {
        featureType: "landscape",
        elementType: "geometry.fill",
        stylers: [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        featureType: "landscape.man_made",
        elementType: "geometry.fill",
        stylers: [
            {
                "color": "#545467",
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        featureType: "landscape.natural",
        elementType: "geometry.fill",
        stylers: [
            {
                "visibility": "on"
            },
            {
                "color": "#424257"
            }
        ]
    },
    {
        featureType: "landscape.natural.landcover",
        elementType: "geometry.fill",
        stylers: [
            {
                "color": "#ebebeb"
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        featureType: "landscape.natural.terrain",
        elementType: "geometry.fill",
        stylers: [
            {
                "color": "#ebebeb"
            },
            {
                "visibility": "on"
            }
        ]
    }






          ]
    });



// MARKER
    var markers = [
        {
            coords:{lat: 50.669501, lng:4.611751},
            iconImage:"",
            content:
                '<div id="infowindow" >' + 
                    '<p>Prix : </p>' +
                    '<p>contact : </p>' +
                    '<p>Voir la fiche : <a href="#page-maison">IcI</a> </p>' +
                    '<p>Adresse : Grand place, 1348 Louvain-la-Neuve </p>' +
                    '<p> <img src="../img/images/box1.jpg" width=90%/> </p>' +
                    
                '</div>'
            

        },

        {
            coords:{lat: 50.665746,  lng: 4.567026},
            content:  
                '<div id="infowindow" >' + 
                    '<p>Adresse : </p>' +	
                    '<p>Prix : </p>' +
                    '<p>contact : </p>' +
                    '<p>Voir la fiche : <a href="#page-maison">IcI</a> </p>' +
                    '<p> <img src="../img/images/box3.jpg" width=90%/> </p>' +
                '</div>'
        },



    ]
    for(var i = 0; i < markers.length; i++){
        addMarker(markers[i]);
    }



// fonction marker
    function addMarker (props){

        var marker = new google.maps.Marker({
        position: props.coords,
        map:map,
        
    });

    // 
    if(props.iconImage){
        marker.setIcon(props.iconImage)
    }


    if(props.content){
             var infowindow = new google.maps.InfoWindow({
        content : props.content,
        
    });
    
    marker.addListener('click', function(){
        infowindow.open(map, marker);
    });
    map.addListener('click', function(){
        infowindow.close();
    });
    }

    
  }
}




// Ancre page LLn vers Page BW
$("#page-lln .back").click(function(){
    open("../index.html#page-brabantwallon", "_parent")
})
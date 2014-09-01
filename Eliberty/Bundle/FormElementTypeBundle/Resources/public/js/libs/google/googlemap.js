/**
 * Created by mbaechtel on 22/05/2014.
 */

/**
 * GoogleMap show a map with markers
 *
 * @param pickupsites pickupsites list to show on the map (json format)
 * @param method callback method on pickupsite click event
 * @param options optional options like 'zoom, center ...'
 * @constructor
 */
var GoogleMap = function(pickupsites, method, options) {
    this.options = {
        center : { lat: 0, lng: 0 },
        zoom: 13,
        hbtemplate: 'google-map-pickupsite-template'
    };

    if (typeof options != 'undefined') {
        _.extend(this.options, options);
    }

    this.map = null;
    this.bounds = new google.maps.LatLngBounds();
    this.center = new google.maps.LatLng(this.options.center.lat, this.options.center.lng);
    this.pickupsites = pickupsites;
    this.choosePickupCallback = method;
    this.template = null;
}

GoogleMap.prototype = {
    /**
     * Init the map on page load
     */
    init : function() {
        google.maps.event.addDomListener(window, 'load', this.initialize());
    },
    /**
     * Init the map and pickupsites to show
     */
    initialize : function() {
        var center = this.center;
        var options = this.options;

        var mapOptions = {
            center: center,
            zoom: options.zoom,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        };

        var source = $("#" + this.options.hbtemplate).html();
        this.template = Handlebars.compile(source);

        this.map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);

        this.addMarkers();

        if (this.options.center.lat == 0) this.fitBounds();
    },
    /**
     * Add pickupsites on the map
     */
    addMarkers : function() {
        var pickupsites = this.pickupsites;
        var myself = this;
        var i = 0;
        _.each(pickupsites, function(site) {
            setTimeout(function() {
                myself.addMarker(site);
            }, i * 600);

            i++;
        });
    },
    /**
     * Add a pickupsite on the map
     *
     * @param site pickupsite to add
     */
    addMarker : function(site) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(site.address.latitude, site.address.longitude),
            map: this.map,
            draggable: false,
            animation: google.maps.Animation.DROP,
            title: site.label
        });

        this.bounds.extend(marker.position);

        var myself = this;

        google.maps.event.addListener(marker, 'click', function() {
            if (typeof infowindow != 'undefined') infowindow.close();
            infowindow = new google.maps.InfoWindow({
                content: myself.template(site),
                maxWidth: 200
            });

            google.maps.event.addListener(infowindow, 'domready', function() {
                $('.btn-marker').on('click', function() {
                    myself.choosePickupCallback($(this).data('site'));
                });
            });

            google.maps.event.addListener(infowindow, 'closeclick', function() {
                myself.fitCenter();
            });

            infowindow.open(myself.map, marker);
        });
    },
    /**
     * Fit bound the map with pickupsites
     */
    fitBounds : function() {
        this.map.fitBounds(this.bounds);
        var myself = this;
        var listener = google.maps.event.addListener(this.map, "idle", function () {
            myself.map.setZoom(myself.options.zoom);
            google.maps.event.removeListener(listener);
        });
    },
    /**
     * Fit center the map
     */
    fitCenter : function() {
        this.map.setZoom(this.options.zoom);
        var c = this.center;
        if (this.options.center.lat == 0) c = this.bounds.getCenter();
        this.map.setCenter(c);
    }
}

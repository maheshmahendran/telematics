# Marker to tell the VCL compiler that this VCL has been adapted to the
# new 4.0 format.
vcl 4.0;
import std;

acl invalidators {
    "localhost";
}

# Default backend definition. Set this to point to your content server.
backend default {
    .host = "127.0.0.1";
    .port = "8080";
    .first_byte_timeout = 600s;
}

sub vcl_recv {

    return(pass);

    # Happens before we check if we have this in cache already.
    #
    # Typically you clean up the request here, removing cookies you don't need,
    # rewriting the request, etc.

    if (req.http.Cookie) {
        set req.http.Cookie = ";" + req.http.Cookie;
        set req.http.Cookie = regsuball(req.http.Cookie, "; +", ";");
        set req.http.Cookie = regsuball(req.http.Cookie, ";(PHPSESSID)=", "; \1=");
        set req.http.Cookie = regsuball(req.http.Cookie, ";[^ ][^;]*", "");
        set req.http.Cookie = regsuball(req.http.Cookie, "^[; ]+|[; ]+$", "");

        if (req.http.Cookie == "") {
            // If there are no more cookies, remove the header to get page cached.
            unset req.http.Cookie;
        }
    }

    unset req.http.Forwarded;

    if (req.http.X-Forwarded-Proto == "https" ) {
        set req.http.X-Forwarded-Port = "443";
    } else {
        set req.http.X-Forwarded-Port = "80";
    }

    if (req.method == "PURGE") {
        if (!client.ip ~ invalidators) {
            return (synth(405, "Not allowed"));
        }
        return (purge);
    }

    if (req.method == "BAN") {
        if (!client.ip ~ invalidators) {
            return (synth(405, "Not allowed"));
        }

        ban("obj.http.X-Host ~ " + req.http.X-Host
            + " && obj.http.X-Url ~ " + req.http.X-Url
            + " && obj.http.content-type ~ " + req.http.X-Content-Type
        );

        return (synth(200, "Banned"));
    }
}

sub vcl_backend_response {
    # Happens after we have read the response headers from the backend.
    #
    # Here you clean the response headers, removing silly Set-Cookie headers
    # and other mistakes your backend does.

    set beresp.http.X-Url = bereq.url;
    set beresp.http.X-Host = bereq.http.host;
}

sub vcl_deliver {
    # Happens when we have all the pieces we need, and are about to send the
    # response to the client.
    #
    # You can do accounting or modifying the final object here.

    set resp.http.Access-Control-Allow-Origin = "*";
    set resp.http.Access-Control-Allow-Credentials = "true";

    if (!resp.http.X-Cache-Debug) {
        # Remove ban-lurker friendly custom headers when delivering to client
        unset resp.http.X-Url;
        unset resp.http.X-Host;
        unset resp.http.X-Cache-Tags;
    }

    if (resp.http.Send-Debug-Info) {
        if (resp.http.X-Varnish ~ " ") {
            set resp.http.X-Cache = "HIT";
        } else {
            set resp.http.X-Cache = "MISS";
        }
    }
}
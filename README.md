# Login Bundle

An opinionated Symfony ~3.0|4.0 Bundle with several helpers for locale management.

Add this bundle to your AppKernel.php `new \Forci\Bundle\LocaleBundle\ForciLocaleBundle()`

`wucdbm_locale.locales_simple` is a simple array of the locale keys

`wucdbm_locale.locales_enabled.routing` is a `en|bg|sw|vn`-like string

```yaml
forci_locale:
    cookie_listener:
        enabled: true
    disabled_locale_redirect_listener:
        enabled: true # if a locale is not enabled, 
        # it will redirect to the same route with the same parameters, 
        # but using the preferred (if any) or the default locale
        use_preferred_locale: true # whether to try using preferred locale or not
    locales:
        en:
            name: English
            enabled: true
            currency: USD
        sw:
            name: Kiswahili
            enabled: true
            currency: TZS
        vn:
            name: Việt
            enabled: true
            currency: VND
```
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About E-Marketplace

This application has implement some library to achieve some feature like 
### Authentication & Authorization
For creating this feature we use library this
- [x] laravel breeze (for starter kit authentication and registration, and profile view)
- [] spatie permissions (for Authorization)
- [] laravel socialite (extending Authentication method use social account like google, facebook)
## Sealed Secret 
We need make sure security for saving secret in repository, so then we use `SealedSecret` with `kubeseal` command utility to encrypt `Secret`.\
This is how to implement it, make sure you have installed sealed secret in your kubernetes cluster.\
We assume has install sealed secret controller in namespace `kube-system`
```
kubeseal --controller-namespace kube-system --format yaml -f deployment/e-marketplace-secret.yaml > deployment/e-marketplace-sealedsecret.yaml
```

If you facing error like this : \
```
Failed to unseal: no key could decrypt secret
```
Its mean have problem with decrypting from controller to namespaced sealed secret\
For temporary solution, we can use scope cluster-wide first
```
kubeseal --scope cluster-wide --controller-namespace kube-system --format yaml -f deployment/e-marketplace-secret.yaml > deployment/e-marketplace-sealedsecret.yaml
```

### References:
- [Login with sso google](https://codyrigg.medium.com/how-to-add-a-google-login-using-socialite-on-laravel-8-with-jetstream-6153581e7dc9)
- [Setup Github actions only passed pull-request check](https://stackoverflow.com/a/58655352)

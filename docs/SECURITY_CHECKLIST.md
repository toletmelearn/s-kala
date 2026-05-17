# S-kala Security Checklist

## Runtime and Environment
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` generated and private
- [ ] `.env` never committed to git

## Credentials and Access
- [ ] Strong admin passwords enforced
- [ ] Super Admin account reviewed regularly
- [ ] Role/permission mappings reviewed
- [ ] Unused admin accounts disabled

## Transport and Hosting
- [ ] HTTPS enabled (valid TLS certificate)
- [ ] HTTP to HTTPS redirect enabled
- [ ] Secure server firewall rules in place

## Data Protection
- [ ] Database backups scheduled
- [ ] `public/uploads` backups scheduled
- [ ] `.env` backup stored privately
- [ ] Restore process tested

## File Upload Security
- [ ] File type validation enabled (PDF/image constraints)
- [ ] File size limits enforced
- [ ] Upload directories writable but controlled
- [ ] No executable upload paths exposed

## Privacy Controls
- [ ] Public pages do not expose trainee private data
- [ ] No phone/address/ID proof exposed in certificate verification
- [ ] Sensitive admin notes not publicly accessible

## Application Hygiene
- [ ] No `dd()`, `dump()`, `var_dump()` in production code
- [ ] No debug-only logs left in frontend scripts
- [ ] Dependency updates reviewed periodically
- [ ] Laravel and package security advisories monitored

## Operations
- [ ] Production deploy uses `--no-dev`
- [ ] Config/route/view caches generated on deploy
- [ ] Failed login and suspicious behavior monitoring enabled (if available)


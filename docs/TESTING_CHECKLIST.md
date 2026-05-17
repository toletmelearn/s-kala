# S-kala Manual Testing Checklist

## Authentication
- [ ] Login with valid credentials
- [ ] Invalid login shows proper validation
- [ ] Logout works and session ends

## Website CMS
- [ ] Website settings update saves correctly
- [ ] Homepage sections CRUD works
- [ ] Impact counters CRUD works
- [ ] CMS changes reflect on public site

## Training Programs
- [ ] Program create/edit/delete works
- [ ] Active/featured toggles work
- [ ] Program image upload works

## Trainers
- [ ] Trainer create/edit/delete works
- [ ] Active toggle works
- [ ] Trainer photo upload works

## Trainees
- [ ] Public `/join` form submits successfully
- [ ] Registration number auto-generates
- [ ] Admin trainee filters work
- [ ] Status updates and notes save
- [ ] Photo and ID proof upload/replace works

## Gallery
- [ ] Category CRUD works
- [ ] Gallery item CRUD works
- [ ] Featured/active toggles work
- [ ] Public `/gallery` filter and display work

## Events
- [ ] Event CRUD works
- [ ] Featured/active toggles work
- [ ] Public `/events` and detail page work

## Products
- [ ] Product category CRUD works
- [ ] Product CRUD works
- [ ] Featured/active toggles work
- [ ] Public `/products` listing/detail works

## Product Enquiries
- [ ] Public product enquiry form works
- [ ] New enquiry appears in admin
- [ ] Status/notes updates work

## Contact Enquiries
- [ ] Public `/contact` submission works
- [ ] Enquiry number auto-generates
- [ ] Admin filters/search/status update work

## Certificates
- [ ] Certificate create/edit/delete (draft) works
- [ ] Issue/revoke actions work
- [ ] Certificate PDF download works
- [ ] Verification URL opens

## Certificate Verification
- [ ] Issued certificate shows authentic state
- [ ] Revoked certificate shows revoked state
- [ ] Invalid code shows not-found state

## CSR Impact Dashboard
- [ ] `/admin/csr-impact` loads real counts
- [ ] Program-wise trainee counts display

## CSR Reports
- [ ] CSR report create/edit/delete works
- [ ] Publish/feature toggles work
- [ ] Report PDF upload (PDF only) validation works
- [ ] Cover image upload validation works
- [ ] Public `/impact` shows featured published reports
- [ ] Public `/csr-reports/{slug}` only shows published reports

## Director Presentation Mode
- [ ] `/admin/presentation` loads
- [ ] Real impact counts display
- [ ] Dashboard button opens presentation mode

## Public Pages
- [ ] All key pages load without errors
- [ ] Navbar links work
- [ ] Footer links work
- [ ] Empty states are presentable (no broken layout)

## Mobile Responsiveness
- [ ] Navbar mobile menu works
- [ ] Cards/grids do not overflow
- [ ] Tables remain usable (scroll as needed)
- [ ] Forms are readable and tappable


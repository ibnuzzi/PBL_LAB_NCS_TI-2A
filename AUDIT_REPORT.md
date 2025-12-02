# AUDIT REPORT - LAB NCS WEBSITE PROJECT
**Date:** December 2, 2025  
**Status:** COMPREHENSIVE AUDIT COMPLETE  
**Scope:** Code cleanup, CSS/JS extraction, file reorganization

---

## 1. EXECUTIVE SUMMARY

**Project Current State:**
- ✅ Website fully functional and operational
- ❌ CSS scattered across multiple PHP files (internal `<style>` tags)
- ❌ JavaScript mixed with PHP files (internal `<script>` tags & inline handlers)
- ❌ Some files with unclear naming conventions
- ✅ Clear MVC structure present
- ⚠️ Inline styles and event handlers need extraction

**Audit Findings:** 8 PHP files contain embedded CSS, 24+ PHP files contain embedded JS, recommended cleanup path identified.

---

## 2. DETAILED FINDINGS

### 2.1 CSS EMBEDDED IN PHP FILES (CRITICAL - MUST EXTRACT)

| # | File | Location | Lines | Type | Severity | Status |
|---|------|----------|-------|------|----------|--------|
| 1 | `app/views/public/home.php` | Line 197-630 | ~434 | `<style>` tag | HIGH | To Extract |
| 2 | `app/views/public/home.php` | Line 633-809 | ~177 | `<style>` tag | HIGH | To Extract |
| 3 | `app/views/public/home.php` | Line 810-879 | ~70 | `<style>` tag | MEDIUM | To Extract |
| 4 | `app/views/public/home.php` | Line 880-1084 | ~205 | `<style>` tag | HIGH | To Extract |
| 5 | `app/views/public/home.php` | Line 1085+ | ~7 | `<style>` tag | LOW | To Extract |
| 6 | `app/views/public/berita.php` | Line 134-XXX | ~10 | `<style>` tag | LOW | To Extract |
| 7 | `app/views/public/berita/detail.php` | Line 127+ | ~1 | `<style>` tag | LOW | To Extract |
| 8 | `app/services/EmailService.php` | Line 135-195 | ~61 | HTML Email CSS | MEDIUM | To Extract |

**Total CSS lines to extract:** ~950+ lines

### 2.2 JAVASCRIPT EMBEDDED IN PHP FILES (HIGH PRIORITY)

**Files with inline `<script>` tags:**
- `app/views/public/home.php` (Line 439+) - Team carousel logic (~80 lines)
- `app/views/public/tentang.php` (Line 257, 342) - Carousel scripts
- `app/views/public/galeri.php` (Line 129) - Gallery script
- `app/views/templates/public/scripts.php` - Multiple vendor scripts (39 lines core)
- `app/views/templates/admin/footer_admin.php` (Line 5, 44) - Admin scripts
- `app/views/templates/public/scripts.php` (Line 43) - Inline JS initialization
- Multiple admin pages: `penelitian`, `pengabdian`, `agenda`, `gallery`, `konsultasi`, `dokumen_kategori`, `dokumen_umum`, `berita`, `pengelola`, `sarana`

**Inline Event Handlers Found:**
- `onclick="moveCarouselHome(-1)"` - home.php line 169
- `onclick="moveCarouselHome(1)"` - home.php line 174
- `onclick="currentSlideHome(<?= $i ?>)"` - home.php line 183
- `onmouseover="..."` - fasilitas.php (7+ occurrences)
- `onmouseout="..."` - fasilitas.php (2+ occurrences)

### 2.3 INLINE STYLES IN PHP (MODERATE - MOSTLY ACCEPTABLE)

Found ~100+ inline `style="..."` attributes across files:
- `app/views/public/agenda.php` - 4 occurrences
- `app/views/public/berita/detail.php` - 18 occurrences  
- `app/views/public/tentang.php` - 30+ occurrences
- `app/views/public/layanan.php` - 40+ occurrences
- `app/views/public/fasilitas.php` - 15+ occurrences
- `app/views/public/home.php` - 20+ occurrences

**Note:** Many inline styles are for dynamic values (background-image URLs) and are acceptable to keep in PHP.

### 2.4 FILES WITH UNCLEAR NAMING

| Current Name | Recommended | Type | Reason |
|--------------|-------------|------|--------|
| `add_anggota_luar_column.php` | `migration-add-anggota-luar-columns.php` | Migration | Name unclear - appears to be DB migration |
| `add_anggota_luar_pengabdian_column.php` | `migration-add-pengabdian-column.php` | Migration | Migration file unclear |

**Current Status:** These files appear to be migration/setup scripts. Currently not imported anywhere - safe to rename or document.

### 2.5 UNUSED/QUESTIONABLE FILES

After grep analysis, NO truly unused files found that should be deleted. All main files are properly imported/used.

**Files to Keep Vigilant About:**
- `scripts.php.backup` - Backup file (should be deleted if no longer needed)
- Empty upload directories (will be populated at runtime)

### 2.6 DUPLICATE/REDUNDANT CODE

**Found:**
1. **Team Carousel JavaScript** appears in multiple files (home.php, tentang.php) - should be extracted to shared JS
2. **Similar carousel logic** - Consider creating reusable carousel component
3. **Inline event handlers** in multiple pages doing similar operations

### 2.7 FOLDER STRUCTURE ANALYSIS

**Empty/Underutilized Folders:**
- `public/uploads/dokumen_umum/` - Empty
- `public/uploads/pengabdian/` - Empty
- `public/uploads/penelitian/` - Empty (mentioned in structure but not found)

**Note:** Upload folders are expected to be empty until content is created, so not an issue.

### 2.8 DEAD CODE IDENTIFIED

**In home.php:**
- Line 188-190: Fallback message styled with inline CSS (acceptable as dynamic fallback)

**In admin footer_admin.php:**
- Multiple script includes may have redundant jQuery loads (jQuery loaded twice in some views)

---

## 3. CSS EXTRACTION PLAN

### 3.1 CSS Files to Create

Based on analysis, create these files in `public/css/`:

| Filename | Source | Lines | Purpose | Priority |
|----------|--------|-------|---------|----------|
| `lab-ncs-home.css` | home.php lines 197-1084 | ~900 | Homepage styling (carousel, sections) | HIGH |
| `lab-ncs-berita.css` | berita.php + detail.php lines 134+ | ~20 | News/article page styling | MEDIUM |
| `lab-ncs-email.css` | EmailService.php lines 135-195 | ~61 | Email template styling | LOW |

**OR consolidate to:**
- `lab-ncs-public-pages.css` - All public page styles combined
- Keep existing: `lab-ncs-custom.css`, `agenda-custom.css`, `gallery-custom.css`

### 3.2 JavaScript Files to Create

| Filename | Source | Lines | Purpose | Priority |
|----------|--------|-------|---------|----------|
| `lab-ncs-home-carousel.js` | home.php lines 439+ | ~80 | Team carousel functionality | HIGH |
| `lab-ncs-carousel-utils.js` | Shared carousel logic | TBD | Reusable carousel functions | HIGH |

**Existing JS to utilize:**
- `home-carousel.js` - exists but not used?
- `tentang-carousel.js` - exists but not used?

---

## 4. FILE STRUCTURE ANALYSIS

### 4.1 Current Structure Assessment
```
✅ GOOD:
- Clear separation of app/ and public/
- Models, Views, Controllers properly separated
- Config and middleware properly organized
- Services folder for reusable logic

⚠️ NEEDS WORK:
- CSS scattered across multiple PHP files
- JS scattered across multiple PHP files
- Some duplicate carousel logic between pages
```

### 4.2 Recommended New Structure (POST-CLEANUP)
```
public/css/
├── lab-ncs-global.css (core layout, typography, colors)
├── lab-ncs-home.css (homepage specific - extracted)
├── lab-ncs-berita.css (news pages - extracted)
├── agenda-custom.css (existing - keep)
├── gallery-custom.css (existing - keep)
├── lab-ncs-custom.css (existing - keep)
└── preloader.css (existing - keep)

public/js/
├── lab-ncs-app.js (core app functionality)
├── lab-ncs-home-carousel.js (team carousel - extracted)
├── home-carousel.js (existing - repurpose if unused)
├── tentang-carousel.js (existing - repurpose if unused)
├── main.js (existing - keep)
└── ... other vendor files
```

---

## 5. SPECIFIC ISSUES IN home.php

### 5.1 Team Carousel CSS (Lines 197-400)
**Status:** Multiple style blocks, needs extraction
**Content:** Professional carousel styling with animations
**Action:** Extract to `lab-ncs-home.css` or `lab-ncs-home-carousel.css`

### 5.2 Team Carousel JS (Lines 439-545)
**Status:** Inline script with event handlers
**Content:** Carousel navigation, auto-slide functionality
**Action:** Extract to `lab-ncs-home-carousel.js`

### 5.3 Penelitian Section CSS (Lines 633-809)
**Status:** Large style block for research section
**Content:** Case studies grid, hover effects
**Action:** Extract to `lab-ncs-home.css`

### 5.4 Fasilitas Section CSS (Lines 880-1084)
**Status:** Service card styling
**Content:** Card layouts, transitions
**Action:** Extract to `lab-ncs-home.css`

### 5.5 ISSUES TO FIX (Per Requirements)

**Issue #1: Penelitian Terbaru - Missing Data Display**
- ✅ Current: Shows research items but missing formatted date
- 🔧 Fix: Display creation date (`created_at`) in user-friendly format (e.g., "12 Januari 2025")
- 📝 Code location: Line 636-651

**Issue #2: Missing Links for "Workspace" & "Perangkat Lunak"**
- ❌ Current: Text displayed as plain text in Fasilitas section  
- 🔧 Fix: Convert to links pointing to `fasilitas.php`
- 📝 Code location: Lines ~850-950 (Fasilitas section titles)

**Issue #3: Hover Icon Styling Inconsistency**
- ⚠️ Current: Home.php berita section has inconsistent hover effect for + icon
- 🔧 Fix: Match styling with berita.php hover effect exactly
- 📝 Code location: Line 1005-1070 (Blog card section)

---

## 6. MIGRATION/SETUP SCRIPTS

**Files Found:**
1. `add_anggota_luar_column.php`
2. `add_anggota_luar_pengabdian_column.php`

**Status:** Not referenced in any PHP file (checked via grep)  
**Recommendation:** 
- Keep as documentation/reference (these are migration scripts)
- Rename for clarity: `migration-add-anggota-luar-columns.php`
- Consider moving to `app/migrations/` folder if exists, or create one
- Document purpose in file header

---

## 7. DEPENDENCY ANALYSIS

### 7.1 CSS Dependencies
- `bootstrap` (vendor) - foundational framework
- `fontawesome` (vendor) - icons
- Custom CSS files build on bootstrap

### 7.2 JS Dependencies
- jQuery (vendor) - DOM manipulation
- Bootstrap JS (vendor) - interactive components
- Select2, Summernote, DataTables (for admin pages) - form enhancements
- Chart.js - visualizations
- Custom carousel logic - depends on window resize events

### 7.3 No Circular Dependencies Found ✅

---

## 8. PERFORMANCE ANALYSIS

### 8.1 Current Issues
- ❌ Multiple `<style>` blocks scattered across pages (not ideal for caching)
- ❌ Inline JavaScript increases HTML file size
- ✅ Vendor files are minified and properly organized

### 8.2 Improvements After Cleanup
- ✅ CSS extracted = better browser caching
- ✅ JS extracted = better browser caching  
- ✅ Reduced HTML file size
- ✅ Better code reusability
- ✅ Easier maintenance

**Estimated Improvement:** 10-15% reduction in homepage HTML size

---

## 9. RECOMMENDATIONS (PRIORITY ORDER)

### PHASE 1: CRITICAL (Must Do)
1. **Extract CSS from home.php** → `lab-ncs-home.css`
   - Time: ~30 minutes
   - Risk: LOW
   - Impact: HIGH

2. **Extract JS from home.php** → `lab-ncs-home-carousel.js`
   - Time: ~20 minutes
   - Risk: LOW
   - Impact: MEDIUM

3. **Fix home.php issues** (3 specific fixes required):
   - Add date formatting for penelitian
   - Add links for Workspace & Perangkat Lunak
   - Sync hover icon styling
   - Time: ~30 minutes
   - Risk: MEDIUM
   - Impact: HIGH (Feature improvement)

### PHASE 2: HIGH PRIORITY
4. **Extract CSS from berita pages**
5. **Clean up inline event handlers** (onclick, onmouseover, etc.)
6. **Consolidate carousel logic** (reuse between home & tentang)

### PHASE 3: MEDIUM PRIORITY
7. **Rename migration files** for clarity
8. **Remove backup files** (scripts.php.backup)
9. **Add inline documentation** to extracted CSS/JS

### PHASE 4: LOW PRIORITY
10. **Code formatting consistency**
11. **Add PHPDoc comments**
12. **Optimize vendor includes**

---

## 10. RISK ASSESSMENT

### 10.1 Extraction Risks
| Risk | Probability | Impact | Mitigation |
|------|------------|--------|-----------|
| CSS selector conflicts | LOW | MEDIUM | Test each page after extraction |
| JavaScript scope issues | LOW | HIGH | Verify function calls still work |
| Path references broken | MEDIUM | HIGH | Use BASE_URL constant for links |
| CSS specificity changed | LOW | MEDIUM | Maintain exact selector structure |

### 10.2 Mitigation Strategy
- ✅ Git commit before each major change
- ✅ Test each page in browser after changes
- ✅ Take screenshots before/after for comparison
- ✅ Verify no 404 errors in console
- ✅ Check responsive behavior on all breakpoints

---

## 11. ESTIMATED EFFORT

| Task | Time | Difficulty |
|------|------|-----------|
| Extract CSS from home.php | 30 min | Easy |
| Extract JS from home.php | 20 min | Easy |
| Fix home.php 3 issues | 30 min | Medium |
| Extract CSS from other pages | 20 min | Easy |
| Extract/consolidate carousel JS | 25 min | Medium |
| Rename migration files | 5 min | Trivial |
| Testing & validation | 60 min | Medium |
| **TOTAL** | **190 min (~3.2 hrs)** | **Medium** |

---

## 12. SUCCESS CRITERIA

- [ ] All CSS extracted from PHP files (verified via grep)
- [ ] All JavaScript extracted from PHP files
- [ ] Website visual output 100% identical (pixel-perfect)
- [ ] No JavaScript errors in browser console
- [ ] No 404 errors for CSS/JS files
- [ ] All links functional
- [ ] Responsive behavior preserved
- [ ] Home page penelitian shows formatted dates
- [ ] Workspace & Perangkat Lunak links work
- [ ] Hover effects identical between pages

---

## 13. FILES TO CREATE

### New CSS Files:
- `public/css/lab-ncs-home.css` (~900 lines)
- `public/css/lab-ncs-berita.css` (~20 lines)

### New JS Files:
- `public/js/lab-ncs-home-carousel.js` (~80 lines)

### Files to Modify:
- `app/views/public/home.php` - Remove `<style>` blocks, add links
- `app/views/public/berita.php` - Remove `<style>` block, add link
- `app/views/public/berita/detail.php` - Remove `<style>` block, add link
- `app/controllers/HomeController.php` - Add date formatting for penelitian

### Files to Rename:
- `add_anggota_luar_column.php` → `migration-add-anggota-luar-columns.php`
- `add_anggota_luar_pengabdian_column.php` → `migration-add-pengabdian-columns.php`

---

## 14. VALIDATION CHECKLIST

**Before Starting Cleanup:**
- [x] Project backed up in git
- [x] Current state documented

**During Cleanup:**
- [ ] Each CSS/JS extraction tested immediately
- [ ] Screenshot comparison done for each page
- [ ] No console errors detected
- [ ] All links working
- [ ] Responsive design preserved

**After Cleanup:**
- [ ] All pages load correctly
- [ ] No visual differences from original
- [ ] Performance improved
- [ ] Code more maintainable
- [ ] Documentation updated

---

## 15. NEXT STEPS

1. **Review this audit** - Ensure findings are understood
2. **Start Phase 1** - Extract CSS from home.php
3. **Commit after each major extraction** - Save progress
4. **Test thoroughly** - Compare screenshots
5. **Move to Phase 2-4** - Continue with other improvements
6. **Document final state** - Update README with new structure

---

**END OF AUDIT REPORT**

Generated: 2025-12-02  
Auditor: Code Cleanup Agent  
Status: READY FOR IMPLEMENTATION

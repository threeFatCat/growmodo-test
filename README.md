# Estatein WordPress Theme

A modern, fully responsive WordPress theme for real estate platforms, built from Figma design specifications.

[Figma Design](https://www.figma.com/community/file/1314076616839640516)

## 🏠 Features

- **Custom Post Types**: Properties and Testimonials with dedicated archive pages
- **Advanced Custom Fields**: Flexible content management with ACF (free version)
- **Fully Responsive**: Mobile-first design optimized for all devices
- **SEO Optimized**: Schema.org structured data, meta tags, and Open Graph support
- **Performance Focused**: Optimized loading, lazy images, and minimal dependencies
- **Accessibility Ready**: ARIA labels, skip links, and semantic HTML5
- **Modern JavaScript**: Vanilla ES6+ with touch/swipe support


## 🚀 Installation

1. **Download or clone the theme:**
   ```bash
   git clone https://github.com/yourusername/estatein-theme.git
   ```

2. **Upload to WordPress:**
   - Navigate to `wp-content/themes/`
   - Upload the `estatein` folder
   - Or use WordPress admin: Appearance → Themes → Add New → Upload Theme

3. **Activate the theme:**
   - Go to Appearance → Themes
   - Click "Activate" on Estatein theme

4. **Install required plugin:**
   - Install and activate Advanced Custom Fields (ACF) plugin
   - The theme will show an admin notice if ACF is missing

5. **Configure menus:**
   - Go to Appearance → Menus
   - Create a menu and assign it to "Primary Menu" location
   - Create a footer menu and assign it to "Footer Menu" location

6. **Set up front page:**
   - Go to Settings → Reading
   - Set "Front page displays" to "A static page"
   - Select your front page (or create a new one)

## 📁 Theme Structure

```
estatein/
├── assets/
│   ├── css/
│   │   └── main.css          # Main stylesheet
│   ├── js/
│   │   └── main.js           # Main JavaScript
│   └── images/               # Theme images
├── inc/
│   ├── acf-fields.php        # ACF field definitions
│   ├── template-functions.php # Helper functions
│   └── schema-markup.php     # Schema.org structured data
├── template-parts/
│   ├── section-hero.php      # Hero section
│   ├── section-features.php  # Features section
│   ├── section-properties.php # Properties section
│   ├── section-testimonials.php # Testimonials section
│   ├── section-faq.php       # FAQ section
│   ├── section-cta.php       # CTA section
│   ├── content-property.php  # Property card template
│   └── content-testimonial.php # Testimonial card template
├── archive-property.php      # Property archive template
├── archive-testimonial.php   # Testimonial archive template
├── front-page.php            # Front page template
├── header.php                # Header template
├── footer.php                # Footer template
├── functions.php             # Theme functions
└── style.css                 # Theme stylesheet (header info)
```

## 🎨 Customization

### ACF Fields

The theme uses Advanced Custom Fields for content management. Fields are automatically available when editing:

- **Front Page**: Hero, Features, Properties, Testimonials sections
- **About Page**: Hero section with statistics
- **Property Posts**: Bedrooms, bathrooms, property type, price
- **Testimonial Posts**: Rating, client name, client location

### Custom Image Sizes

The theme registers custom image sizes:
- `estatein-property-large`: 800x600px
- `estatein-property-thumb`: 400x300px
- `estatein-hero`: 1920x1080px

### Theme Settings

Navigate to **Appearance → Theme Settings** to configure:
- Top banner visibility and content
- Banner link settings


## 🔧 Development

- WordPress Coding Standards
- PHP 8.3.17
- ES6+ JavaScript
- Modern CSS (Grid, Flexbox)


## 🔍 SEO Features

- **Schema.org Structured Data:**
  - Organization
  - WebSite
  - RealEstateAgent
  - Product (Properties)
  - BreadcrumbList

- **Meta Tags:**
  - Meta descriptions
  - Open Graph tags
  - Title tags

- **Semantic HTML:**
  - Proper heading hierarchy
  - ARIA labels
  - Alt attributes for images


## ♿ Accessibility

- Skip to content link
- ARIA labels on interactive elements
- Keyboard navigation support
- Screen reader friendly
- Focus indicators
- Semantic HTML5

## 🛡️ Security

- Nonce verification on forms
- Data sanitization and escaping
- ABSPATH checks
- Input validation
- WordPress security best practices



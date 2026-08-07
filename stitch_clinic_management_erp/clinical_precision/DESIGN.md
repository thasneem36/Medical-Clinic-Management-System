---
name: Clinical Precision
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#3f4850'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#707881'
  outline-variant: '#bfc7d2'
  surface-tint: '#006398'
  primary: '#006194'
  on-primary: '#ffffff'
  primary-container: '#007bb9'
  on-primary-container: '#fdfcff'
  inverse-primary: '#93ccff'
  secondary: '#006a61'
  on-secondary: '#ffffff'
  secondary-container: '#86f2e4'
  on-secondary-container: '#006f66'
  tertiary: '#595c5e'
  on-tertiary: '#ffffff'
  tertiary-container: '#727577'
  on-tertiary-container: '#fbfdff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#cce5ff'
  primary-fixed-dim: '#93ccff'
  on-primary-fixed: '#001d31'
  on-primary-fixed-variant: '#004b73'
  secondary-fixed: '#89f5e7'
  secondary-fixed-dim: '#6bd8cb'
  on-secondary-fixed: '#00201d'
  on-secondary-fixed-variant: '#005049'
  tertiary-fixed: '#e0e3e5'
  tertiary-fixed-dim: '#c4c7c9'
  on-tertiary-fixed: '#191c1e'
  on-tertiary-fixed-variant: '#444749'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 26px
    fontWeight: '700'
    lineHeight: 32px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  sidebar-width: 260px
  gutter: 1.5rem
  margin-page: 2rem
  stack-sm: 0.5rem
  stack-md: 1rem
  stack-lg: 2rem
---

## Brand & Style
The design system is engineered for high-stakes healthcare environments, prioritizing cognitive ease, trust, and clinical efficiency. The aesthetic is **Modern Corporate Minimalism** with a focus on high legibility and spaciousness to reduce practitioner burnout. 

The emotional response should be one of "composed reliability." By utilizing a white-dominant interface with strategic splashes of calming teals and blues, the UI feels hygienic yet technologically advanced. The style avoids unnecessary decoration, relying on structural alignment and soft elevation to guide the user through complex ERP workflows like patient scheduling and billing.

## Colors
The palette is anchored in a "Medical Blue" (#0284c7) for primary actions and a "Healing Teal" (#0d9488) for secondary emphasis and healthcare-specific indicators. 

- **Backgrounds**: Use pure white (#FFFFFF) for the main canvas to ensure maximum contrast for text.
- **Surfaces**: Use the light gray (#f8fafc) for cards, section containers, and zebra-striping to create subtle visual grouping without heavy borders.
- **Status Indicators**: Use highly saturated green, yellow, and red for badges to ensure immediate recognition of patient or payment status.
- **Typography Colors**: Use Slate-800 (#1e293b) for headings and Slate-600 (#475569) for body text to maintain a soft but readable contrast.

## Typography
This design system utilizes **Inter** exclusively to ensure a systematic, utilitarian feel that performs exceptionally well in data-heavy tables and forms. 

- **Hierarchy**: Use `headline-lg` for dashboard overviews and `headline-md` for patient names or section titles.
- **Data Display**: In ERP tables, use `body-md` for standard entries to maximize information density while maintaining legibility.
- **Labels**: Small caps or high-weight labels should be used for form headers and table headers to distinguish them from user-inputted data.

## Layout & Spacing
The design system employs a **Desktop-First Fixed Sidebar** model. 

- **Sidebar**: A persistent 260px left navigation bar contains primary app modules (Calendar, Patients, Billing). On mobile, this transitions to a bottom-tab bar or a slide-out drawer.
- **Grid**: Use a 12-column fluid grid for the main content area with a max-width container of 1440px to prevent line lengths from becoming unreadable on ultra-wide monitors.
- **Rhythm**: Apply a strict 8px (0.5rem) spacing scale. Sections should be separated by `stack-lg`, while related form elements use `stack-sm`.

## Elevation & Depth
To maintain the professional and trustworthy aesthetic, depth is achieved through **Tonal Layers** and **Ambient Shadows**.

- **Level 0**: Background (#FFFFFF).
- **Level 1**: Card surfaces (#f8fafc) with a subtle 1px border (#e2e8f0).
- **Level 2**: Active modals or dropdowns, utilizing a very soft, diffused shadow (0px 10px 15px -3px rgba(0, 0, 0, 0.05)) to suggest interaction without cluttering the clinical space.
- **Focus**: Use a primary-colored glow (2px outer ring) for active input fields to guide the user's eye during rapid data entry.

## Shapes
The design system uses a "Rounded XL" philosophy for major containers to soften the technical nature of an ERP.

- **Standard Elements**: Buttons and Input fields use a 0.5rem (8px) radius.
- **Container Elements**: Main dashboard cards and the sidebar utilize a 1.5rem (24px) corner radius to create a distinct, modern "app-like" feel.
- **Badges**: Status badges should be fully pill-shaped (rounded-full) to differentiate them from interactive buttons.

## Components

- **Sidebar Navigation**: Fixed to the left. Icons are 24px line-art style (Lucide or similar). Active states use a "light blue" background tint with a vertical primary-color bar on the left edge.
- **Zebra Tables**: Essential for ERP readability. Use #f8fafc for even rows and #ffffff for odd rows. Hover states should highlight the entire row in a very pale teal (#f0fdfa).
- **Status Badges**: 
  - *Confirmed*: Green background (10% opacity) with Green-700 text.
  - *Pending*: Yellow background (10% opacity) with Yellow-700 text.
  - *Overdue*: Red background (10% opacity) with Red-700 text.
- **Buttons**: Primary buttons are solid Blue (#0284c7) with white text. Secondary buttons are outlined in Teal (#0d9488) with Teal text.
- **Input Fields**: Large, clear touch targets (min 44px height). Labels sit consistently above the field, never as placeholder text alone.
- **Data Cards**: Used for patient summaries. Features a subtle "Level 2" shadow on hover to indicate clickability.
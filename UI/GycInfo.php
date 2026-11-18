<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Shared markup for the Participant Info blocks (gyc/info-*).
 * Tailwind scans this file (see @source in assets/css/app.css), so its classes can stay here.
 */
class GycInfo
{
    const BACKGROUNDS = array(
        'white' => 'bg-white text-gyc-plum',
        'cream' => 'bg-gyc-cream text-gyc-plum',
        'lilac' => 'bg-gyc-lilac text-gyc-plum',
        'plum' => 'bg-linear-to-b from-gyc-plum to-gyc-plum-mid text-white',
    );

    const ICONS = array(
        'ticket' => '<path d="M4 7.5A1.5 1.5 0 0 1 5.5 6h13A1.5 1.5 0 0 1 20 7.5V10a2 2 0 0 0 0 4v2.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 16.5V14a2 2 0 0 0 0-4z"/><path d="M14 6v2M14 11v2M14 16v2"/>',
        'people' => '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9.5" r="2.3"/><path d="M3.5 19c0-3 2.5-5.5 5.5-5.5s5.5 2.5 5.5 5.5M15 13.6c.6-.2 1.3-.3 2-.3 2.2 0 4 1.8 4 4.2V19"/>',
        'meal' => '<path d="M7 3v8M4.5 3v5a2.5 2.5 0 0 0 5 0V3M7 11v10M17 21V3c-2.2 1-3.5 3.5-3.5 7v3H17"/>',
        'leaf' => '<path d="M5 19c0-8 5-13 15-14-1 10-6 15-14 15"/><path d="M5 19l7-7"/>',
        'bed' => '<path d="M3 6v13M3 15h18v4M21 15v-2.5a2.5 2.5 0 0 0-2.5-2.5H11v5"/><circle cx="7" cy="11.5" r="1.5"/>',
        'pin' => '<path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11z"/><circle cx="12" cy="10" r="2.3"/>',
        'plane' => '<path d="M3 14.5l7-1.5 4.5 5.5 1.8-.6-2-6.3 4.6-1a1.7 1.7 0 0 0-.7-3.3l-4.6 1-4.5-4.6-1.8.6 2.2 5.4-4 .9-1.6-1.6-1.4.4z"/>',
        'train' => '<rect x="6" y="3.5" width="12" height="13" rx="3"/><path d="M6 10.5h12M9.5 13.5h.01M14.5 13.5h.01M8.5 20.5l1.5-4M15.5 20.5l-1.5-4"/>',
        'bus' => '<rect x="4.5" y="3.5" width="15" height="14" rx="2.5"/><path d="M4.5 10.5h15M8 14h.01M16 14h.01M7.5 17.5v2.5M16.5 17.5v2.5"/>',
        'calendar' => '<rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/><circle cx="12" cy="15" r="1"/>',
        'heart' => '<path d="M12 20s-7.5-4.6-7.5-10A4.3 4.3 0 0 1 12 7.2 4.3 4.3 0 0 1 19.5 10c0 5.4-7.5 10-7.5 10z"/>',
        'music' => '<path d="M9 18V5.5l11-2V16"/><circle cx="6.5" cy="18" r="2.5"/><circle cx="17.5" cy="16" r="2.5"/>',
        'document' => '<path d="M14 3.5H7A1.5 1.5 0 0 0 5.5 5v14A1.5 1.5 0 0 0 7 20.5h10a1.5 1.5 0 0 0 1.5-1.5V8z"/><path d="M14 3.5V8h4.5M9 12.5h6M9 16h6"/>',
        'euro' => '<path d="M17.5 6.5A6.5 6.5 0 1 0 17.5 17.5M4.5 10.5h9M4.5 13.5h9"/>',
        'hands' => '<path d="M12 20.5l-6.5-6.5a3 3 0 0 1 0-4.2l1.3-1.3L12 13.7M12 20.5l6.5-6.5a3 3 0 0 0 0-4.2l-1.3-1.3L12 13.7M9 5.5l3 3 3-3"/>',
        'chat' => '<path d="M5.5 4.5h13A1.5 1.5 0 0 1 20 6v9a1.5 1.5 0 0 1-1.5 1.5H10l-4.5 3.5v-3.5h0A1.5 1.5 0 0 1 4 15V6a1.5 1.5 0 0 1 1.5-1.5z"/>',
        'video' => '<rect x="3.5" y="6.5" width="12" height="11" rx="2"/><path d="M15.5 10.5l5-3v9l-5-3"/>',
        'cube' => '<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9z"/><path d="M4 7.5l8 4.5 8-4.5M12 12v9"/>',
        'book' => '<path d="M12 6.5c-1.8-1.3-4.5-2-7.5-2v13c3 0 5.7.7 7.5 2 1.8-1.3 4.5-2 7.5-2v-13c-3 0-5.7.7-7.5 2zM12 6.5v13"/>',
        'frame' => '<rect x="4" y="3.5" width="16" height="17" rx="1.5"/><circle cx="12" cy="10" r="2.8"/><path d="M7.5 17.5c.8-2.2 2.5-3.5 4.5-3.5s3.7 1.3 4.5 3.5"/>',
        // The statue of Daniel 2: tall crown, head, broad shoulders, kilt, legs and a round base
        'statue' => '<path d="M9.8 1.5h4.4l-.8 2.8h-2.8z"/><circle cx="12" cy="5.6" r="1.3"/><path d="M7.2 11V9.6c0-1.2 2.1-2 4.8-2s4.8.8 4.8 2V11zM8.6 11h6.8l.9 4.8H7.7zM10.5 15.8v4.2M13.5 15.8v4.2M8 22c0-.8 1.8-1.4 4-1.4s4 .6 4 1.4z"/>',
        // Open hand holding a heart: the "How can we help" survey
        'helping-hands' => '<path d="M12 10.5s-3.5-2-3.5-4.4A1.9 1.9 0 0 1 12 5a1.9 1.9 0 0 1 3.5 1.1c0 2.4-3.5 4.4-3.5 4.4z"/><path d="M3 13v7.5M3 14.5h2.8l2.7-1.5h4.7a1.6 1.6 0 0 1 0 3.2h-3.2"/><path d="M3 19.5h2.8l2.2-.8h7.5l4.9-3.2a1.6 1.6 0 0 0-1.9-2.5l-5.3 2.7"/>',
        // Dove in flight: the Religious Liberty survey
        // One outline: beak and round head on the left, a two-feather wing sweeping up to the right, crescent tail below
        'dove' => '<path d="M2 7.6C3 5.8 5.6 4.9 7 6.6c.6.8.8 1.8 1 2.7 2.5-3.7 7.5-5.1 14-4.7-2 2.8-3.5 4-5.5 4.6l3.9.4c-1.8 2.2-3.8 3.1-6.4 3.4 2 2.6 4.4 4.2 7 4.6-4.5 2.4-11 1.4-13.5-3.6-.7-1.6-1.9-3.2-3.7-4.4z"/>',
        // Two hands pressed together with their sleeves: prayer
        'house' => '<path d="M3.5 11L12 4l8.5 7"/><path d="M5.5 9.5V20h13V9.5"/><path d="M10 20v-5.5h4V20"/>',
        'pray' => '<path d="M12 1.5v2M7.5 2.8l1.1 1.4M16.5 2.8l-1.1 1.4"/><path d="M12 6.5c-1.3 0-2.1 1-2.4 2.5L8.6 14l-3.1 3 3.4 3.5L12 18l3.1 2.5 3.4-3.5-3.1-3-1-5C14.1 7.5 13.3 6.5 12 6.5z"/><path d="M12 6.5V18M8.8 14.2l1.7 2M15.2 14.2l-1.7 2M4 18.8l3 3M20 18.8l-3 3"/>',
        // Walking person: the prayer walk
        'walk' => '<circle cx="14" cy="4" r="2"/><path d="M13 8l-2.2 6.5L7 21M10.8 14.5l4 2.5 1.5 4M13 8.3L8.5 10.5 7 14M13 8.3l2.2 4 3.8 1.2"/>',
        'sun' => '<circle cx="12" cy="12" r="4"/><path d="M12 2.5v2M12 19.5v2M2.5 12h2M19.5 12h2M5.3 5.3l1.4 1.4M17.3 17.3l1.4 1.4M5.3 18.7l1.4-1.4M17.3 6.7l1.4-1.4"/>',
    );

    public static function background($attributes, $default)
    {
        $key = empty($attributes['background']) ? $default : $attributes['background'];

        return isset(self::BACKGROUNDS[$key]) ? $key : $default;
    }

    public static function is_active($attributes)
    {
        return !isset($attributes['active']) || $attributes['active'];
    }

    /**
     * Section ID the hero buttons jump to.
     */
    public static function anchor($attributes, $default)
    {
        $id = empty($attributes['anchorId']) ? $default : sanitize_title($attributes['anchorId']);

        return $id === '' ? $default : $id;
    }

    /**
     * Opening <section>, content wrapper and the label, title and intro.
     */
    public static function open($attributes, $default_anchor, $default_background)
    {
        $background = self::background($attributes, $default_background);
        $is_dark = $background === 'plum';
        $anchor = self::anchor($attributes, $default_anchor);
        $title_id = 'gyc-info-' . $anchor . '-title';
        $eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
        $title = empty($attributes['title']) ? null : $attributes['title'];
        $text = empty($attributes['text']) ? null : $attributes['text'];

        ob_start();
        ?>
        <section
            id="<?php echo esc_attr($anchor); ?>"
            class="scroll-mt-8 py-16 md:py-24 <?php echo esc_attr(self::BACKGROUNDS[$background]); ?>"
            <?php if ($title): ?>aria-labelledby="<?php echo esc_attr($title_id); ?>"<?php endif; ?>>
            <div class="max-w-content mx-auto px-6 md:px-12">
                <?php if ($eyebrow || $title || $text): ?>
                    <div class="max-w-2xl space-y-4">
                        <?php if ($eyebrow): ?>
                            <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase <?php echo $is_dark ? 'text-gyc-mint' : 'text-gyc-teal'; ?>"><?php echo esc_html($eyebrow); ?></p>
                        <?php endif; ?>
                        <?php if ($title): ?>
                            <h2 id="<?php echo esc_attr($title_id); ?>" class="font-display small-caps text-4xl md:text-5xl leading-none <?php echo $is_dark ? 'text-gyc-ivory' : ''; ?>"><?php echo esc_html($title); ?></h2>
                        <?php endif; ?>
                        <?php if ($text): ?>
                            <p class="font-jakarta text-sm md:text-base leading-relaxed whitespace-pre-line <?php echo $is_dark ? 'text-white/85' : 'text-gyc-plum/80'; ?>"><?php echo esc_html($text); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
        <?php

        return ob_get_clean();
    }

    public static function close()
    {
        return '</div></section>';
    }

    /**
     * Square icon badge. $variant: 'mint' (mint square, plum icon) or 'plum' (plum square, mint icon).
     * $image_url: an editor's own icon from the Media Library, used instead of the built-in $name.
     */
    public static function icon_badge($name, $variant = 'mint', $size = 'md', $image_url = '')
    {
        $image_url = trim((string) $image_url);
        $has_icon = !empty($name) && isset(self::ICONS[$name]);
        if ($image_url === '' && !$has_icon) {
            return '';
        }

        $box = $size === 'lg' ? 'h-12 w-12 rounded-xl' : 'h-10 w-10 rounded-xl';
        $colors = $variant === 'plum' ? 'bg-gyc-plum-mid text-gyc-mint' : 'bg-gyc-mint text-gyc-plum';
        $inner = $image_url !== ''
            ? '<img src="' . esc_url($image_url) . '" alt="" loading="lazy" class="h-6 w-6 object-contain" />'
            : self::svg($name, 'h-5 w-5');

        return '<span class="flex shrink-0 items-center justify-center ' . $box . ' ' . $colors . '" aria-hidden="true">' . $inner . '</span>';
    }

    public static function svg($name, $classes)
    {
        if (empty($name) || !isset(self::ICONS[$name])) {
            return '';
        }

        return '<svg class="' . esc_attr($classes) . '" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">' . self::ICONS[$name] . '</svg>';
    }

    /**
     * Pill button with an arrow, optionally greyed out until a "Registration opens" time (CET).
     * $variant: 'plum' (purple button, for light backgrounds) or 'mint' (mint button, for purple ones).
     * Empty label or link: nothing is shown.
     */
    public static function button($label, $url, $opens_value = '', $variant = 'plum')
    {
        $url = empty($url) ? '' : GycUI::resolve_url($url, false);
        if (empty($label) || $url === '') {
            return '';
        }

        $is_mint = $variant === 'mint';
        $is_external = strpos($url, home_url()) !== 0 && preg_match('#^https?://#', $url);
        $arrow = $is_external ? '<path d="M7 17L17 7M9 7h8v8"/>' : '<path d="M5 12h14M13 6l6 6-6 6"/>';

        $link = '<a href="' . esc_url($url) . '"'
            . ($is_external ? ' target="_blank" rel="noopener noreferrer"' : '')
            . ' class="inline-flex items-center gap-2 rounded-full px-7 py-3.5 font-jakarta text-sm font-semibold motion-safe:transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 '
            . ($is_mint ? 'bg-gyc-mint text-gyc-plum hover:bg-gyc-mint-dark focus-visible:outline-gyc-mint' : 'bg-gyc-plum text-white hover:bg-gyc-plum-light focus-visible:outline-gyc-plum')
            . '">' . esc_html($label)
            . ($is_external ? '<span class="sr-only">' . esc_html__('(opens in a new tab)', 'gyc') . '</span>' : '')
            . '<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">' . $arrow . '</svg></a>';

        $opens_at = GycUI::opens_at($opens_value);
        if (!$opens_at) {
            return $link;
        }

        return GycUI::closed_button(
            $opens_at,
            $link,
            $label,
            'inline-flex cursor-not-allowed items-center rounded-full px-7 py-3.5 font-jakarta text-sm font-semibold ' . ($is_mint ? 'bg-white/15 text-white/60' : 'bg-gyc-plum/10 text-gyc-plum/55'),
            'pl-1 pt-2 font-jakarta text-xs ' . ($is_mint ? 'text-gyc-mint' : 'text-gyc-plum/80')
        );
    }

    /**
     * Non-empty lines of a textarea, for bullet lists.
     */
    public static function lines($value)
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $value))));
    }

    /**
     * Bullet list with mint (dark cards) or teal (light cards) dots.
     */
    public static function bullets($value, $is_dark = false)
    {
        $lines = self::lines($value);
        if (count($lines) === 0) {
            return '';
        }

        $html = '<ul class="mt-4 space-y-2.5 font-jakarta text-sm leading-relaxed ' . ($is_dark ? 'text-white/85' : 'text-gyc-plum/80') . '" role="list">';
        foreach ($lines as $line) {
            $html .= '<li class="relative pl-5"><span class="absolute left-0 top-[0.55em] h-1.5 w-1.5 rounded-full ' . ($is_dark ? 'bg-gyc-mint' : 'bg-gyc-teal') . '" aria-hidden="true"></span>' . esc_html($line) . '</li>';
        }

        return $html . '</ul>';
    }

    /**
     * Light mint box with a round plum icon, at the end of a section.
     * $icon: 'check' (a confirmation) or 'info' (a hint).
     */
    public static function note($text, $icon = 'info')
    {
        if (empty($text)) {
            return '';
        }

        $path = $icon === 'check'
            ? '<path d="M5 12.5l4.5 4.5L19 7.5"/>'
            : '<path d="M12 8h.01M11 12h1v5h1"/><circle cx="12" cy="12" r="9"/>';

        return '<div class="mt-6 md:mt-8 flex items-center gap-4 rounded-2xl bg-gyc-mint/20 px-5 py-4 md:px-6 md:py-5">'
            . '<span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gyc-plum-mid text-gyc-mint" aria-hidden="true">'
            . '<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">' . $path . '</svg>'
            . '</span>'
            . '<p class="font-jakarta text-sm leading-relaxed whitespace-pre-line">' . esc_html($text) . '</p>'
            . '</div>';
    }

    /**
     * Google Maps embed address from what an editor pasted: the whole <iframe> code from
     * Google Maps → Share → Embed a map, or only its src. Anything not served by Google Maps
     * is ignored, so no other site can be embedded.
     */
    public static function map_embed_url($value)
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (preg_match('/src\s*=\s*["\']([^"\']+)["\']/i', $value, $match)) {
            $value = $match[1];
        }

        $url = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
        $parts = wp_parse_url($url);
        if (empty($parts['scheme']) || $parts['scheme'] !== 'https' || empty($parts['host']) || empty($parts['path'])) {
            return null;
        }

        $host = strtolower($parts['host']);
        $is_google = in_array($host, array('www.google.com', 'google.com', 'maps.google.com'), true);
        $is_maps = strpos($parts['path'], '/maps') === 0;

        return ($is_google && $is_maps) ? $url : null;
    }
}

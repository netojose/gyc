<?php
$eyebrow = empty($attributes['eyebrow']) ? null : $attributes['eyebrow'];
$title = empty($attributes['title']) ? null : $attributes['title'];
$text = empty($attributes['text']) ? null : $attributes['text'];
$link_label = empty($attributes['linkLabel']) ? null : $attributes['linkLabel'];
$video_url = empty($attributes['videoUrl']) ? null : $attributes['videoUrl'];
$poster = empty($attributes['poster']) ? null : $attributes['poster'];
$poster_alt = empty($attributes['posterAlt']) ? '' : $attributes['posterAlt'];
$overlay_text = empty($attributes['overlayText']) ? null : $attributes['overlayText'];

// YouTube and Vimeo links are played through their embed player, anything else as a video file.
$embed_url = null;
if ($video_url) {
    if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/))([\w-]{11})~', $video_url, $matches)) {
        $embed_url = 'https://www.youtube-nocookie.com/embed/' . $matches[1] . '?autoplay=1&rel=0';
    } elseif (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $video_url, $matches)) {
        $embed_url = 'https://player.vimeo.com/video/' . $matches[1] . '?autoplay=1';
    }
}
$player_label = $title ? sprintf('Play video: %s', $title) : 'Play video';
?>
<section
    class="bg-white text-gyc-ink"
    <?php if ($title): ?>aria-labelledby="gyc-video-title"<?php endif; ?>
    x-data="{ playing: false, play() { this.playing = true; this.$nextTick(function () { if (this.$refs.player) { this.$refs.player.focus(); } }.bind(this)); } }">
    <div class="grid grid-cols-1 lg:grid-cols-12">
        <div class="relative lg:col-span-7 aspect-video lg:aspect-auto lg:min-h-[30rem] bg-[#0a1433] overflow-hidden">
            <?php if ($video_url): ?>
                <template x-if="playing">
                    <?php if ($embed_url): ?>
                        <iframe
                            x-ref="player"
                            class="absolute inset-0 h-full w-full"
                            src="<?php echo esc_url($embed_url); ?>"
                            title="<?php echo esc_attr($title ? $title : 'Video'); ?>"
                            allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                            allowfullscreen></iframe>
                    <?php else: ?>
                        <video
                            x-ref="player"
                            class="absolute inset-0 h-full w-full bg-black object-contain"
                            src="<?php echo esc_url($video_url); ?>"
                            controls
                            autoplay
                            playsinline></video>
                    <?php endif; ?>
                </template>
            <?php endif; ?>

            <<?php echo $video_url ? 'a' : 'div'; ?>
                <?php if ($video_url): ?>
                    href="<?php echo esc_url($video_url); ?>"
                    aria-label="<?php echo esc_attr($player_label); ?>"
                    @click.prevent="play()"
                <?php endif; ?>
                x-show="!playing"
                class="group absolute inset-0 block focus-visible:outline-4 focus-visible:-outline-offset-4 focus-visible:outline-gyc-mint">
                <?php if ($poster): ?>
                    <img
                        class="absolute inset-0 h-full w-full object-cover motion-safe:transition-transform duration-500 ease-out motion-safe:group-hover:scale-105"
                        src="<?php echo esc_url($poster); ?>"
                        alt="<?php echo esc_attr($video_url ? '' : $poster_alt); ?>"
                        loading="lazy"
                        decoding="async"
                        draggable="false" />
                <?php else: ?>
                    <span class="absolute inset-0 bg-linear-to-br from-[#1d3fa8] via-[#0e1f5c] to-[#050b1c]" aria-hidden="true"></span>
                <?php endif; ?>

                <span class="absolute inset-0 bg-linear-to-t from-black/50 via-transparent to-transparent" aria-hidden="true"></span>

                <?php if ($video_url): ?>
                    <span class="absolute left-1/2 top-1/2 flex h-16 w-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-sm border-2 border-white/90 bg-black/30 text-white backdrop-blur-sm motion-safe:transition-colors group-hover:bg-gyc-teal" aria-hidden="true">
                        <svg class="ml-1 h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5.5v13l11-6.5z"></path></svg>
                    </span>
                <?php endif; ?>

                <?php if ($overlay_text): ?>
                    <span class="absolute bottom-6 left-6 md:bottom-10 md:left-16 -rotate-3 font-script text-3xl md:text-5xl uppercase leading-none text-white whitespace-pre-line drop-shadow-[0_2px_6px_rgba(0,0,0,0.6)]" aria-hidden="true"><?php echo esc_html($overlay_text); ?></span>
                <?php endif; ?>
            </<?php echo $video_url ? 'a' : 'div'; ?>>
        </div>

        <div class="lg:col-span-5 flex items-center px-6 md:px-12 lg:px-16 py-14 lg:py-20">
            <div class="max-w-md space-y-5">
                <?php if ($eyebrow): ?>
                    <p class="font-jakarta text-xs font-bold tracking-[0.25em] uppercase text-gyc-ink/80"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 id="gyc-video-title" class="font-jakarta text-4xl md:text-5xl font-extrabold uppercase leading-none tracking-tight text-gyc-ink">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p class="font-jakarta text-base leading-relaxed text-gyc-ink/85 whitespace-pre-line"><?php echo esc_html($text); ?></p>
                <?php endif; ?>

                <?php if ($link_label && $video_url): ?>
                    <a
                        href="<?php echo esc_url($video_url); ?>"
                        @click.prevent="play()"
                        class="inline-flex items-center gap-3 border-b-2 border-gyc-ink pb-1.5 font-jakarta text-xs font-bold uppercase tracking-[0.2em] text-gyc-ink motion-safe:transition-colors hover:text-gyc-teal hover:border-gyc-teal focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-gyc-teal">
                        <?php echo esc_html($link_label); ?>
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5.5v13l11-6.5z"></path></svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

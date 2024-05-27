@push('head-scripts')
    @auth
        <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
    @endauth
@endpush

@push('body-scripts')
    <script>
        const htmlElement = document.querySelector('html');
        const theme = htmlElement.getAttribute('data-bs-theme');

        const postTextArea = document.getElementById('post-textarea');
        const emojiButton = document.getElementById('post-emoji-button');
        const pickerOptions = {
            onEmojiSelect: onClickEmoji,
            locale: 'pl',
            theme: theme,
            emojiButtonColors: [
                'rgba(155, 223, 88, .7)',
                'rgba(149, 211, 254, .7)',
                'rgba(247, 233, 34, .7)',
                'rgba(238, 166, 252, .7)',
                'rgba(255, 213, 143, .7)',
                'rgba(211, 209, 255, .7)',
            ],
        }
        const emojiPicker = new EmojiMart.Picker(pickerOptions)

        let emojiPickerVisible = false;

        emojiButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Zatrzymuje propagację kliknięcia, aby nie wywoływać zamykania pickera
            const buttonRect = emojiButton.getBoundingClientRect();

            if (!emojiPickerVisible) {
                emojiPicker.style.position = 'absolute';
                emojiPicker.style.top = (buttonRect.bottom + window.scrollY) + 'px';
                emojiPicker.style.left = (buttonRect.left + window.scrollX) + 'px';
                document.body.appendChild(emojiPicker);
                emojiPickerVisible = true;
            } else {
                document.body.removeChild(emojiPicker);
                emojiPickerVisible = false;
            }
        });

        document.addEventListener('click', (event) => {
            if (!emojiPicker.contains(event.target)) {
                if (emojiPickerVisible) {
                    document.body.removeChild(emojiPicker);
                    emojiPickerVisible = false;
                }
            }
        });

        function onClickEmoji(event) {
            const emoji = event.native;
            postTextArea.value += emoji;

            const _submitButton = document.getElementById('post-submit-button');
            if (_submitButton) {
                submitButton.disabled = false;
            }
        }
    </script>
@endpush

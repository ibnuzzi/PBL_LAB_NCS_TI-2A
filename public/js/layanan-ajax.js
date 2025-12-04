// AJAX handler for Layanan form submission
jQuery(document).ready(function($) {
    $('.contact-one__form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const button = form.find('button[type="submit"]');
        const buttonText = button.html();

        // Disable button and show loading state
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');

        // Get form data
        const formData = new FormData(this);

        // Send AJAX request with X-Requested-With header
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Parse response if string
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        Toast.show({
                            type: 'error',
                            title: 'Error',
                            message: 'Terjadi kesalahan saat memproses response.',
                            duration: 6000
                        });
                        return;
                    }
                }

                if (response.success) {
                    // Reset form
                    form[0].reset();

                    // Show success toast notification
                    Toast.show({
                        type: 'success',
                        title: 'Pertanyaan Terkirim!',
                        message: response.message || 'Terima kasih! Pertanyaan Anda telah berhasil dikirim.',
                        duration: 7000
                    });

                    // Scroll to FAQ section smoothly
                    setTimeout(function() {
                        $('html, body').animate({
                            scrollTop: $('.blog-one').offset().top - 100
                        }, 800);
                    }, 1500);
                } else {
                    // Show error toast
                    Toast.show({
                        type: 'error',
                        title: 'Gagal Mengirim',
                        message: response.message || 'Maaf, terjadi kesalahan.',
                        duration: 6000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);
                
                Toast.show({
                    type: 'error',
                    title: 'Gagal Mengirim',
                    message: 'Maaf, terjadi kesalahan. Silakan coba lagi.',
                    duration: 6000
                });
            },
            complete: function() {
                // Re-enable button
                button.prop('disabled', false);
                button.html(buttonText);
            }
        });
    });
});

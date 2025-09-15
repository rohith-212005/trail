// payment.js
document.addEventListener('DOMContentLoaded', () => {
    // Get the ticket details from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const ticketName = urlParams.get('ticketName');
    const ticketPrice = urlParams.get('price');
    const from = urlParams.get('from');
    const to = urlParams.get('to');
    const date = urlParams.get('date');

    // Set the ticket details on the payment page
    if (ticketName && ticketPrice) {
        document.getElementById('ticket-name').textContent = ticketName;
        document.getElementById('ticket-price').textContent = ticketPrice;
    }

    // Handle form submission
    const paymentForm = document.getElementById('payment-form');
    paymentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Get form data
        const passengerName = document.getElementById('name').value;

        // Simulate payment processing
        alert('Payment Successful! Your ticket has been booked.');

        // Generate additional ticket details
        const seatNumber = "12A"; // Replace with dynamic seat if available
        const ticketNumber = `TK-${Math.floor(100000000 + Math.random() * 900000000)}`;

        // Redirect to ticket page with all details
        const redirectUrl = `ticket.html?name=${encodeURIComponent(passengerName)}&ticketName=${encodeURIComponent(ticketName)}&price=${encodeURIComponent(ticketPrice)}&from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}&date=${encodeURIComponent(date)}&seat=${encodeURIComponent(seatNumber)}&ticket=${encodeURIComponent(ticketNumber)}`;
        window.location.href = redirectUrl;
    });
});
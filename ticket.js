// ticket.js
document.addEventListener('DOMContentLoaded', () => {
    // Get ticket details from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const ticketData = {
        passengerName: urlParams.get('name') || "Unknown Passenger",
        ticketName: urlParams.get('ticketName') || "Unknown Ticket",
        ticketPrice: urlParams.get('price') || "N/A",
        travelDate: urlParams.get('date') || "N/A",
        seatNumber: urlParams.get('seat') || "N/A",
        ticketNumber: urlParams.get('ticket') || "N/A"
    };

    // Update ticket details on the page
    document.getElementById('passenger-name').textContent = ticketData.passengerName;
    document.getElementById('ticket-name').textContent = ticketData.ticketName;
    document.getElementById('ticket-price').textContent = ticketData.ticketPrice;
    document.getElementById('travel-date').textContent = ticketData.travelDate;
    document.getElementById('seat-number').textContent = ticketData.seatNumber;
    document.getElementById('ticket-number').textContent = ticketData.ticketNumber;

    // Generate QR code with ticket details
    const qrText = `Ticket: ${ticketData.ticketNumber}, Name: ${ticketData.passengerName}, Type: ${ticketData.ticketName}, Price: ${ticketData.ticketPrice}, Seat: ${ticketData.seatNumber}, Date: ${ticketData.travelDate}`;
    new QRCode(document.getElementById('qrcode'), {
        text: qrText,
        width: 150,
        height: 150,
        colorDark: '#2c3e50',
        colorLight: '#ffffff'
    });
});
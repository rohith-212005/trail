import mongoose from 'mongoose';

const paymentSchema = new mongoose.Schema({
    userId: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User',
        required: true
    },
    bookingId: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'Booking',
        required: true
    },
    passengerName: {
        type: String,
        required: true,
        trim: true
    },
    ticketType: {
        type: String,
        required: true,
        trim: true
    },
    price: {
        type: Number,
        required: true,
        min: 0
    },
    paymentMethod: {
        type: String,
        required: true,
        enum: ['credit_card', 'debit_card', 'net_banking', 'upi', 'wallet']
    },
    cardNumber: {
        type: String,
        required: true,
        trim: true
    },
    expiryDate: {
        type: String,
        required: true,
        trim: true
    },
    cvv: {
        type: String,
        required: true,
        trim: true
    },
    email: {
        type: String,
        required: true,
        trim: true,
        lowercase: true
    },
    ticketNumber: {
        type: String,
        unique: true,
        required: true
    },
    seatNumber: {
        type: String,
        required: true,
        trim: true
    },
    paymentStatus: {
        type: String,
        default: 'pending',
        enum: ['pending', 'completed', 'failed', 'refunded']
    },
    transactionId: {
        type: String,
        unique: true,
        sparse: true
    },
    createdAt: {
        type: Date,
        default: Date.now
    },
    updatedAt: {
        type: Date,
        default: Date.now
    }
});

// Update the updatedAt field before saving
paymentSchema.pre('save', function(next) {
    this.updatedAt = Date.now();
    next();
});

export default mongoose.model('Payment', paymentSchema, 'payments');

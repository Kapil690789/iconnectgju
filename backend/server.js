const express = require('express');
const cors = require('cors');
const app = express();

// Enable CORS for all origins (or specify origins as needed)
app.use(cors());

app.use(express.json());  // Middleware to parse JSON requests

// Example login endpoint
app.post('/login', (req, res) => {
  const { email, password } = req.body;

  // Your login logic (check email/password, etc.)
  if (email === 'test@example.com' && password === 'password123') {
    return res.json({ success: true, message: 'Login successful' });
  } else {
    return res.status(401).json({ success: false, message: 'Invalid credentials' });
  }
});

const port = 3000;
app.listen(port, () => {
  console.log(`Server running on http://localhost:${port}`);
});

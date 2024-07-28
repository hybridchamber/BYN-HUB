const express = require('express');
const axios = require('axios');
const app = express();
const port = 3000;

const GOOGLE_API_KEY = 'AIzaSyApnQI6Lb0RIpUvJpJEprr1wG0xMBgfPbg';  // Replace with your actual API key

app.use(express.json());

// Function to fetch address details from Google Places API
const fetchPlaceDetails = async (input, inputtype = 'textquery') => {
  const response = await axios.get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', {
    params: {
      input,
      inputtype,
      fields: 'formatted_address,name,geometry',
      key: GOOGLE_API_KEY,
    },
  });
  return response.data;
};

// Endpoint to validate address
app.get('/validate-address', async (req, res) => {
  const { address } = req.query;
  try {
    const data = await fetchPlaceDetails(address);
    res.json(data);
  } catch (error) {
    console.error('Error validating address:', error);
    res.status(500).json({ error: 'Failed to validate address' });
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});

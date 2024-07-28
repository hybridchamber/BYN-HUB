import axios from 'axios';

const BASE_URL = 'http://localhost:3000';

export const validateAddress = async (address) => {
  const response = await axios.get(`${BASE_URL}/validate-address`, {
    params: { address },
  });
  return response.data;
};

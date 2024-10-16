<template>
    <div>
        <p v-if="loading">Loading...</p> <!-- Show loading indicator -->
        <p v-if="error">{{ error }}</p> <!-- Show error message -->
        <div v-if="data"> <!-- Show data when available -->
            <pre>{{ data }}</pre> 
        </div>
    </div>
</template>

<script>
import axios from 'axios'; // Use import instead of require
import { ref, onMounted } from 'vue'; // Import the Vue lifecycle hook

export default {

    setup() {

        const data = ref(null);
        const error = ref(null);
        const loading = ref(true);

        const fetchData = async () => {
            const options = {
                method: 'POST',
                url: 'https://linkedin-data-api.p.rapidapi.com/posts/reposts',
                headers: {
                    'x-rapidapi-key': 'd001da98f6msh65b48c40d287efcp1b012fjsn8fec95a4c7ba',
                    'x-rapidapi-host': 'linkedin-data-api.p.rapidapi.com',
                    'Content-Type': 'application/json'
                },
                data: {
                    urn: '7245786832909557760',
                    page: 1,
                    paginationToken: ''
                }
            };

            try {
                const response = await axios.request(options);
                data.value = response.data;
            } catch (error) {
                error.value = 'Failed to fetch data';
            } finally {
                loading.value = false;
            }
        };

        onMounted(fetchData);

        return {
            data,
            error,
            loading
        }; // Return an empty object if no data is needed in the template
    },
};
</script>
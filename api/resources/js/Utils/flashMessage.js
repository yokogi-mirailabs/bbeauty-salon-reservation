import { toast } from 'vue3-toastify';

const notify = (message, type) => {
    switch (type) {
        case 'success':
            toast.success(message, {
                autoClose: 3000,
            })
            break;
        case 'error':
            toast.error(message, {
                autoClose: 3000,
            })
            break;
    }
}

export default notify
import { usePage } from "@inertiajs/vue3";

export function usePermission() {
    const page = usePage();

    const hasRole = (name) => {
        const user = page.props.auth.user;
        return user && user.roles && user.roles.includes(name);
    };

    const hasPermission = (name) => {
        const user = page.props.auth.user;
        return user && user.permissions && user.permissions.includes(name);
    };

    return { hasRole, hasPermission };
}

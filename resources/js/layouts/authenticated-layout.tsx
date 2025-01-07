import {usePage} from '@inertiajs/react';
import {PropsWithChildren} from 'react';

export default function Authenticated({children}: PropsWithChildren) {
    const user = usePage().props.auth.user;

    return (
        <div>
            <main>{children}</main>
        </div>
    );
}

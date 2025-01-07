import LoginForm from '@/components/auth/login-form';
import SignUpForm from '@/components/auth/sign-up-form';
import Guest from '@/layouts/guest-layout';
import {PropsWithChildren} from 'react';

export default function WelcomeScreen({children}: PropsWithChildren) {
    return (
        <Guest className={'flex w-full justify-center gap-4'}>
            <SignUpForm/>
            <LoginForm/>
        </Guest>
    );
}

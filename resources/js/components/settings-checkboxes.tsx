import { router } from '@inertiajs/react';
import { useTransition } from 'react';

export default () => {
    const [pending, startTransition] = useTransition();
    const url = new URL(window.location.href);
    const onlyCoverts = url.searchParams.get('onlyCoverts') === 'true';
    const onlyPersonal = url.searchParams.get('onlyPersonal') === 'true';

    const setSearchParams = (name: string, value: string) => {
        if (value === 'false') {
            url.searchParams.delete(name);
        } else {
            url.searchParams.set(name, value);
        }
        startTransition(() => {
            // "Visit" the URL to update the URL and trigger a new request
            router.visit(url.href, {
                showProgress: true,
                preserveState: true,
                only: ['unboxes'],
            });
        });
    };

    return (
        <div className="flex flex-wrap justify-center gap-x-2">
            <div className="flex items-center gap-1">
                <input
                    className="h-4 w-4 accent-[#048b59] disabled:cursor-not-allowed"
                    style={{ colorScheme: 'light' }}
                    type="checkbox"
                    id="onlyCovertsCheckbox"
                    defaultChecked={onlyCoverts}
                    disabled={pending}
                    onChange={(e) => setSearchParams('onlyCoverts', e.target.checked.toString())}
                />
                <label className={`pt-[2px] text-lg ${pending ? 'cursor-not-allowed' : ''}`} htmlFor="onlyCovertsCheckbox">
                    Show only coverts
                </label>
            </div>

            <div className="flex items-center gap-1">
                <input
                    className="h-4 w-4 accent-[#048b59] disabled:cursor-not-allowed"
                    style={{ colorScheme: 'light' }}
                    type="checkbox"
                    id="onlyPersonalCheckbox"
                    defaultChecked={onlyPersonal}
                    disabled={pending}
                    onChange={(e) => setSearchParams('onlyPersonal', e.target.checked.toString())}
                />
                <label className={`pt-[2px] text-lg ${pending ? 'cursor-not-allowed' : ''}`} htmlFor="onlyPersonalCheckbox">
                    Show only mine
                </label>
            </div>
        </div>
    );
};

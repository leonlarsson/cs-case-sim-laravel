import { Link } from '@inertiajs/react';
import { useRef } from 'react';
import { Button } from './button';

export const AboutButtonWithModal = () => {
    const dialogRef = useRef<HTMLDialogElement>(null);
    return (
        <>
            <Button variant="secondary-darker" onClick={() => dialogRef.current?.showModal()}>
                ?
            </Button>

            <dialog
                className="mx-auto w-full max-w-lg border-[1px] border-white/30 bg-[#2d2d2d]/50 text-xl text-white backdrop-blur-xl backdrop:bg-black/30 backdrop:backdrop-blur-sm"
                ref={dialogRef}
            >
                <div className="flex flex-col">
                    <span className="bg-[#262626]/70 p-3 text-3xl font-semibold text-neutral-400">Counter-Strike Case Simulator</span>

                    <div className="flex flex-col gap-3 p-2">
                        <p>This is the Counter-Strike 2 case opening UI recreated in React and Next.js.</p>

                        <p>
                            To see a list of the last items unboxed by the entire community, go{' '}
                            <Link className="font-semibold hover:underline" href="/unboxed">
                                here
                            </Link>
                            .
                        </p>

                        <p>
                            The creator of this website can be found{' '}
                            <Link className="font-semibold hover:underline" href="https://x.com/MozzyFX" target="_blank">
                                here
                            </Link>
                            .
                            <br />
                            The data is fetched from{' '}
                            <Link className="font-semibold hover:underline" href="https://github.com/ByMykel/CSGO-API" target="_blank">
                                here
                            </Link>
                            .
                        </p>

                        <p>
                            <span className="underline">And remember</span>: just because you unbox a cool item here doesn't mean you'll get one
                            in-game. Perform your hobby responsibly, or not at all.
                        </p>

                        <Button variant="secondary-darker" className="self-end" onClick={() => dialogRef.current?.close()}>
                            OK
                        </Button>
                    </div>
                </div>
            </dialog>
        </>
    );
};

import { MonthlyPipe } from '../../core/pipes/monthly.pipe';

describe('MonthlyPipe', () => {
  it('create an instance', () => {
    const pipe = new MonthlyPipe();
    expect(pipe).toBeTruthy();
  });
});
